<?php

namespace App\Filament\Resources\RondaScheduleResource\Pages;

use App\Filament\Resources\RondaScheduleResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRondaSchedule extends EditRecord
{
    protected static string $resource = RondaScheduleResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
