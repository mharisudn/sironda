<?php

namespace App\Filament\Resources;

use App\Filament\Imports\PollingCodeImporter;
use App\Filament\Resources\PollingCodeResource\Pages;
use App\Models\PollingCode;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\ImportAction;
use Filament\Tables\Table;

class PollingCodeResource extends Resource
{
    protected static ?string $model = PollingCode::class;

    protected static ?string $navigationIcon = 'heroicon-o-users';

    protected static ?string $navigationGroup = 'Master';

    protected static ?string $navigationLabel = 'Kode Polling';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('code')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('code')
                    ->searchable(),
                Tables\Columns\TextColumn::make('name')
                    ->label('Petugas')
                    ->searchable(),
                Tables\Columns\TextColumn::make('shift_type')
                    ->label('Shift')
                    ->badge(),
                Tables\Columns\ToggleColumn::make('is_leader')
                    ->label('Ketua'),
                Tables\Columns\ToggleColumn::make('is_locked')
                    ->label('Kunci'),
                Tables\Columns\TextColumn::make('created_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
                Tables\Columns\TextColumn::make('updated_at')
                    ->dateTime()
                    ->sortable()
                    ->toggleable(isToggledHiddenByDefault: true),
            ])
            ->filters([
                //
            ])
            ->headerActions([
                ImportAction::make()
                    ->importer(PollingCodeImporter::class),
            ])
            ->actions([
                Tables\Actions\EditAction::make(),
            ])
            ->bulkActions([
                Tables\Actions\BulkActionGroup::make([
                    Tables\Actions\DeleteBulkAction::make(),
                ]),
            ]);
    }

    public static function getRelations(): array
    {
        return [
            //
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListPollingCodes::route('/'),
            'create' => Pages\CreatePollingCode::route('/create'),
            'edit' => Pages\EditPollingCode::route('/{record}/edit'),
        ];
    }
}
