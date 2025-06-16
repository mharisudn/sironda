<?php

namespace App\Livewire;

use App\Models\PollingCode;
use Livewire\Attributes\Title;
use Livewire\Component;

class SubmitPollingCode extends Component
{
    public string $code = '';

    public function submit()
    {
        $this->validate([
            'code' => ['required', 'string'],
        ]);

        $input = trim($this->code);

        $pollingCode = PollingCode::where('code', $input)
            ->orWhere('name', 'ilike', "%{$input}%")
            ->first();

        if (! $pollingCode) {
            $this->addError('code', 'Kode atau nama tidak ditemukan.');

            return;
        }

        return redirect()->route('polling.form', $pollingCode->code);
    }

    #[Title('Polling Code')]
    public function render()
    {
        return view('livewire.submit-polling-code');
    }
}
