<?php

namespace App\Filament\Resources\RondaPeriodeResource\Pages;

use App\Filament\Resources\RondaPeriodeResource;
use Filament\Actions;
use Filament\Resources\Pages\EditRecord;

class EditRondaPeriode extends EditRecord
{
    protected static string $resource = RondaPeriodeResource::class;

    protected function getHeaderActions(): array
    {
        return [
            Actions\DeleteAction::make(),
        ];
    }
}
