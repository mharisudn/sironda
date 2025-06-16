<?php

namespace App\Livewire;

use App\Models\PollingCode;
use App\Models\PollingSubmission;
use App\Models\RondaPeriode;
use Livewire\Attributes\Layout;
use Livewire\Attributes\Title;
use Livewire\Component;

class PollingForm extends Component
{
    public PollingCode $pollingCode;

    public array $selectedTerminIds = [];

    public function mount($code)
    {
        $this->pollingCode = PollingCode::where('code', $code)->firstOrFail();

        $periode = $this->getActivePeriode();
        if (! $periode) {
            abort(404, 'Polling sudah ditutup.');
        }

        $this->selectedTerminIds = $this->pollingCode
            ->pollingSubmissions()
            ->pluck('ronda_termin_id')
            ->toArray();
    }

    public function getActivePeriode()
    {
        return RondaPeriode::where('is_active', true)
            ->where('is_locked', false)
            ->latest()
            ->first();
    }

    public function updatedSelectedTerminIds()
    {
        // Maksimal 2 pilihan termin
        if (count($this->selectedTerminIds) > 2) {
            $this->selectedTerminIds = array_slice($this->selectedTerminIds, 0, 2);
        }
    }

    public function submit()
    {
        $this->validate([
            'selectedTerminIds' => ['required', 'array', 'min:2', 'max:2'],
        ], [
            'selectedTerminIds.min' => 'Kamu harus memilih minimal 2 termin.',
            'selectedTerminIds.max' => 'Kamu hanya bisa memilih maksimal 2 termin.',
        ]);

        $periode = $this->getActivePeriode();
        if (! $periode) {
            session()->flash('error', 'Polling telah ditutup.');

            return;
        }

        $validTerminIds = $periode->rondaTermins->pluck('id')->toArray();

        // Filter termin dari periode aktif
        $selected = array_filter($this->selectedTerminIds, fn ($id) => in_array($id, $validTerminIds));

        // Hapus pilihan lama
        PollingSubmission::where('polling_code_id', $this->pollingCode->id)
            ->whereIn('ronda_termin_id', $validTerminIds)
            ->delete();

        foreach (array_values($selected) as $index => $terminId) {
            PollingSubmission::create([
                'polling_code_id' => $this->pollingCode->id,
                'ronda_termin_id' => $terminId,
                'sort' => $index + 1,
                'submitted_at' => now(),
            ]);
        }

        session()->flash('success', 'Pilihan ronda kamu berhasil disimpan.');
    }

    #[Layout('layouts.app')]
    #[Title('Termin Ronda')]
    public function render()
    {
        $periode = $this->getActivePeriode();
        if (! $periode) {
            return view('pages.polling.closed');
        }

        $termins = $periode->rondaTermins()->orderBy('start_date')->get();

        return view('livewire.polling-form', [
            'pollingCode' => $this->pollingCode,
            'termins' => $termins,
            'selected' => $this->selectedTerminIds,
        ]);
    }
}
