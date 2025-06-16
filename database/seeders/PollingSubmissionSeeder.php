<?php

namespace Database\Seeders;

use App\Models\PollingCode;
use App\Models\PollingSubmission;
use App\Models\RondaPeriode;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class PollingSubmissionSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $periode = RondaPeriode::where('is_active', true)
            ->where('is_locked', false)
            ->latest()
            ->first();

        if (! $periode) {
            $this->command->warn('Tidak ada Ronda Periode aktif.');

            return;
        }

        $terminIds = $periode->rondaTermins->pluck('id')->toArray();

        if (count($terminIds) < 2) {
            $this->command->warn('Perlu minimal 2 termin untuk polling.');

            return;
        }

        $pollingCodes = PollingCode::all();

        DB::transaction(function () use ($pollingCodes, $terminIds) {
            foreach ($pollingCodes as $code) {
                // Ambil 1–2 termin acak
                $chosenTerminIds = collect($terminIds)->shuffle()->take(rand(2, 2))->values();

                foreach ($chosenTerminIds as $index => $terminId) {
                    PollingSubmission::create([
                        'polling_code_id' => $code->id,
                        'ronda_termin_id' => $terminId,
                        'sort' => $index + 1,
                        'submitted_at' => now()->subMinutes(rand(0, 1440)),
                    ]);
                }
            }
        });

        $this->command->info('PollingSubmission seeded.');
    }
}
