<?php

namespace App\Filament\Resources\PollingCodeResource\Pages;

use App\Filament\Resources\PollingCodeResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListPollingCodes extends ListRecords
{
    protected static string $resource = PollingCodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
