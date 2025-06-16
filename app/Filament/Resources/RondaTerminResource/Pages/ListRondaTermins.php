<?php

namespace App\Filament\Resources\RondaTerminResource\Pages;

use App\Filament\Resources\RondaTerminResource;
use Filament\Actions;
use Filament\Resources\Pages\ListRecords;

class ListRondaTermins extends ListRecords
{
    protected static string $resource = RondaTerminResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\CreateAction::make(),
        ];
    }
}
