<?php

namespace App\Services;

use App\Models\PollingCode;
use App\Models\PollingSubmission;
use App\Models\RondaPeriode;
use App\Models\RondaSchedule;
use Illuminate\Support\Facades\DB;

class RondaShuffleService
{
    public function shuffle(RondaPeriode $periode): void
    {
        DB::transaction(function () use ($periode) {
            RondaSchedule::whereHas('rondaTermin', fn ($q) => $q->where('ronda_periode_id', $periode->id))->delete();

            $termins = $periode->rondaTermins()->withCount('rondaSchedules')->get();
            $terminIds = $termins->pluck('id')->toArray();

            $pollingSubmissions = PollingSubmission::with(['pollingCode', 'rondaTermin'])
                ->whereHas('rondaTermin', fn ($q) => $q->where('ronda_periode_id', $periode->id))
                ->get()
                ->sortBy('sort')
                ->groupBy('polling_code_id');

            $previousTerminMap = $this->getPreviousTerminMap($periode);
            $assignedPollingCodeIds = collect();

            $lockedSubmissions = collect();
            $unlockedSubmissions = collect();

            foreach ($pollingSubmissions as $pollingCodeId => $submissions) {
                $pollingCode = $submissions->first()?->pollingCode;
                if (! $pollingCode) continue;

                if ($pollingCode->is_locked) {
                    $lockedSubmissions->put($pollingCodeId, $submissions);
                } else {
                    $unlockedSubmissions->put($pollingCodeId, $submissions);
                }
            }

            foreach ($lockedSubmissions as $pollingCodeId => $submissions) {
                if (isset($previousTerminMap[$pollingCodeId])) {
                    $assignedPollingCodeIds->push($pollingCodeId);
                    continue;
                }

                $firstSubmission = $submissions->where('sort', 1)->first();
                $termin = $firstSubmission?->rondaTermin;
                $pollingCode = $firstSubmission?->pollingCode;

                if (! $termin || ! $pollingCode) continue;

                $quota = $termin->max_petugas;
                $currentCount = RondaSchedule::where('ronda_termin_id', $termin->id)->count();

                if ($currentCount < $quota) {
                    RondaSchedule::create([
                        'polling_code_id' => $pollingCodeId,
                        'ronda_termin_id' => $termin->id,
                        'shift_type' => $pollingCode->shift_type ?? 'Mix',
                    ]);
                    $assignedPollingCodeIds->push($pollingCodeId);
                }
            }

            $shuffledUnlocked = $unlockedSubmissions->shuffle();
            foreach ($shuffledUnlocked as $pollingCodeId => $submissions) {
                if (isset($previousTerminMap[$pollingCodeId])) continue;

                $pollingCode = $submissions->first()?->pollingCode;
                if (! $pollingCode) continue;

                $sortedSubmissions = $submissions->sortBy('sort');

                foreach ($sortedSubmissions as $submission) {
                    $termin = $submission->rondaTermin;
                    $quota = $termin->max_petugas;
                    $currentCount = RondaSchedule::where('ronda_termin_id', $termin->id)->count();

                    if ($currentCount < $quota) {
                        RondaSchedule::create([
                            'polling_code_id' => $pollingCode->id,
                            'ronda_termin_id' => $termin->id,
                            'shift_type' => $pollingCode->shift_type ?? 'Pagi',
                        ]);
                        $assignedPollingCodeIds->push($pollingCodeId);
                        break;
                    }
                }
            }

            $assignedIds = RondaSchedule::whereHas('rondaTermin', fn ($q) => $q->where('ronda_periode_id', $periode->id))
                ->pluck('polling_code_id')
                ->toArray();

            $unpolled = PollingCode::whereNotIn('id', $assignedIds)->get();

            if ($unpolled->isEmpty()) return;

            $sortedTermins = $termins->map(function ($termin) {
                $currentCount = RondaSchedule::where('ronda_termin_id', $termin->id)->count();
                $termin->available_slots = max(0, $termin->max_petugas - $currentCount);
                return $termin;
            })->sortByDesc('available_slots')->values();

            $shuffledUnpolled = $unpolled->shuffle();
            $index = 0;

            foreach ($shuffledUnpolled as $pollingCode) {
                if (isset($previousTerminMap[$pollingCode->id])) continue;

                $assigned = false;
                foreach ($sortedTermins as $termin) {
                    $currentCount = RondaSchedule::where('ronda_termin_id', $termin->id)->count();

                    if ($currentCount < $termin->max_petugas) {
                        RondaSchedule::create([
                            'polling_code_id' => $pollingCode->id,
                            'ronda_termin_id' => $termin->id,
                            'shift_type' => $pollingCode->shift_type ?? 'Mix',
                        ]);
                        $assigned = true;
                        break;
                    }
                }

                if (! $assigned && $termins->count() > 0) {
                    $targetTermin = $termins[$index % $termins->count()];
                    RondaSchedule::create([
                        'polling_code_id' => $pollingCode->id,
                        'ronda_termin_id' => $targetTermin->id,
                        'shift_type' => $pollingCode->shift_type ?? 'Mix',
                    ]);
                }

                $index++;
            }
        });
    }

    protected function getPreviousTerminMap(RondaPeriode $currentPeriode): array
    {
        $previousPeriode = RondaPeriode::where('start_date', '<', $currentPeriode->start_date)
            ->orderByDesc('start_date')
            ->first();

        if (! $previousPeriode) return [];

        return RondaSchedule::whereHas('rondaTermin', fn ($q) => $q->where('ronda_periode_id', $previousPeriode->id))
            ->pluck('ronda_termin_id', 'polling_code_id')
            ->toArray();
    }
}
