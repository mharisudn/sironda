<?php

namespace App\Filament\Resources\RondaTerminResource\RelationManagers;

use Filament\Resources\RelationManagers\RelationManager;
use Filament\Tables;
use Filament\Tables\Table;

class RondaSchedulesRelationManager extends RelationManager
{
    protected static string $relationship = 'rondaSchedules';

    public function table(Table $table): Table
    {
        return $table
            ->recordTitleAttribute('name')
            ->columns([
                Tables\Columns\TextColumn::make('index')
                    ->rowIndex()
                    ->label('No')
                    ->searchable(),
                Tables\Columns\TextColumn::make('pollingCode.name')
                    ->label('Nama Petugas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shift_type')
                    ->badge(),
            ])
            ->defaultSort('shift_type', 'desc')
            ->paginated(false)
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
