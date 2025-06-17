<?php

namespace App\Filament\Resources\RondaScheduleResource\Pages;

use App\Filament\Resources\RondaScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRondaSchedules extends ListRecords
{
    protected static string $resource = RondaScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
