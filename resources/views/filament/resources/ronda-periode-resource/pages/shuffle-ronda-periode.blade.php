<x-filament-panels::page>
    <div class="space-y-4">
        <h2 class="text-xl font-bold">Acak Jadwal Ronda untuk: {{ $record->name }}</h2>
        <p>Rentang tanggal: {{ $record->start_date->format('d M Y') }} - {{ $record->end_date->format('d M Y') }}</p>

        <form wire:submit.prevent="shuffle">
            <x-filament::button type="submit" color="primary">
                Acak Jadwal Sekarang
            </x-filament::button>
        </form>
    </div>
</x-filament-panels::page>
