<?php

namespace App\Filament\Resources\RondaTerminResource\Pages;

use App\Filament\Resources\RondaTerminResource;
use App\Models\PollingSubmission;
use Filament\Pages\Actions\Action;
use Filament\Resources\Pages\Page;
use Filament\Tables;
use Filament\Tables\Concerns\InteractsWithTable;

class ViewRondaTermin extends Page implements Tables\Contracts\HasTable
{
    use InteractsWithTable;

    protected static string $resource = RondaTerminResource::class;

    public $record;

    public function mount($record): void
    {
        $this->record = RondaTerminResource::resolveRecordRouteBinding($record);
    }

    protected function getTableQuery()
    {
        return PollingSubmission::query()
            ->where('ronda_termin_id', $this->record->id)
            ->with('pollingCode');
    }

    protected function getTableColumns(): array
    {
        return [
            Tables\Columns\TextColumn::make('pollingCode.name')
                ->label('Nama Pegawai')
                ->searchable(),
            Tables\Columns\TextColumn::make('pollingCode.code')
                ->label('Kode Polling'),
            Tables\Columns\TextColumn::make('submitted_at')
                ->label('Tanggal Submit')
                ->dateTime('d M Y, H:i'),
        ];
    }

    protected function getHeaderActions(): array
    {
        return [
            Action::make('Back')
                ->label('Kembali')
                ->url(RondaTerminResource::getUrl())
                ->color('gray'),
        ];
    }
}
