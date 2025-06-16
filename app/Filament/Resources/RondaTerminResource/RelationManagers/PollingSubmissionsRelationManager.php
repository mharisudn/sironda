<?php

namespace App\Filament\Resources\RondaTerminResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class PollingSubmissionsRelationManager extends RelationManager
{
    protected static string $relationship = 'pollingSubmissions';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->label('No')
                    ->rowIndex(),
                Tables\Columns\TextColumn::make('pollingCode.name')
                    ->label('Nama Petugas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('submitted_at')
                    ->label('Waktu Pengisian')
                    ->dateTime('d M Y, H:i'),
                Tables\Columns\TextColumn::make('sort')
                    ->label('Pilihan Ke')
                    ->sortable()
                    ->alignCenter(),
            ])
            ->filters([
                //
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
                Tables\Actions\DeleteAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }
}
