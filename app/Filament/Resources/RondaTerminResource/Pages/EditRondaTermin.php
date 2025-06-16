<?php

namespace App\Filament\Resources\RondaTerminResource\Pages;

use App\Filament\Resources\RondaTerminResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRondaTermin extends EditRecord
{
    protected static string $resource = RondaTerminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
