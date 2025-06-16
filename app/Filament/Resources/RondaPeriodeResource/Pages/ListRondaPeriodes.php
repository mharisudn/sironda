<?php

namespace App\Filament\Resources\RondaPeriodeResource\Pages;

use App\Filament\Resources\RondaPeriodeResource;
use App\Filament\Resources\RondaPeriodeResource\Widgets\PollingTerminStats;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRondaPeriodes extends ListRecords
{
    protected static string $resource = RondaPeriodeResource::class;

    protected function getHeaderWidgets(): array
    {
        return [
            PollingTerminStats::class,
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
