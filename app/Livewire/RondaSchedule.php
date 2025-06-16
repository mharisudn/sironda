<?php

namespace App\Livewire;

use App\Models\RondaPeriode;
use Livewire\Attributes\Title;
use Livewire\Component;

class RondaSchedule extends Component
{
    public $periode;

    public $termins = [];

    public function mount()
    {
        $this->periode = RondaPeriode::where('is_active', true)->latest()->first();

        if ($this->periode) {
            $this->termins = $this->periode->rondaTermins()->with(['rondaSchedules' => fn ($q) => $q->orderBy('shift_type', 'desc')->with('pollingCode')])
                ->orderBy('start_date')
                ->get();
        }
    }

    #[Title('Jadwal Ronda')]
    public function render()
    {
        return view('livewire.ronda-schedule');
    }
}
