<?php

namespace App\Filament\Resources\PollingCodeResource\Pages;

use App\Filament\Resources\PollingCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditPollingCode extends EditRecord
{
    protected static string $resource = PollingCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
