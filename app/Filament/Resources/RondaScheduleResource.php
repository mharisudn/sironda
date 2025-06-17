<?php

namespace App\Filament\Resources;

use App\Enums\ShiftType;
use App\Filament\Resources\RondaScheduleResource\Pages;
use App\Filament\Resources\RondaScheduleResource\RelationManagers;
use App\Models\RondaSchedule;
use Filament\Forms;
use Filament\Forms\Form;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Table;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\SoftDeletingScope;

class RondaScheduleResource extends Resource
{
    protected static ?string $model = RondaSchedule::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Ronda';

    protected static ?string $navigationLabel = 'Jadwal';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\Select::make('ronda_termin_id')
                    ->searchable()
                    ->preload()
                    ->relationship('rondaTermin', 'name')
                    ->required(),
                Forms\Components\Select::make('polling_code_id')
                    ->relationship('pollingCode', 'name')
                    ->required(),
                Forms\Components\Select::make('shift_type')
                    ->options(ShiftType::class)
                    ->searchable()
                    ->preload()
                    ->required(),
                Forms\Components\Toggle::make('is_leader')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('rondaTermin.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('pollingCode.name')
                    ->numeric()
                    ->sortable(),
                Tables\Columns\TextColumn::make('shift_type')
                    ->searchable(),
                Tables\Columns\IconColumn::make('is_leader')
                    ->boolean(),
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
            'index' => Pages\ListRondaSchedules::route('/'),
//            'create' => Pages\CreateRondaSchedule::route('/create'),
//            'edit' => Pages\EditRondaSchedule::route('/{record}/edit'),
        ];
    }
}
