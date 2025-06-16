<?php

namespace App\Filament\Resources;

use App\Filament\Resources\RondaPeriodeResource\Pages;
use App\Models\RondaPeriode;
use App\Services\RondaShuffleService;
use App\Services\RondaTerminGeneratorService;
use Filament\Forms;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Notifications\Notification;
use Filament\Resources\Resource;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Table;

class RondaPeriodeResource extends Resource
{
    protected static ?string $model = RondaPeriode::class;

    protected static ?string $navigationIcon = 'heroicon-o-calendar-days';

    protected static ?string $navigationGroup = 'Ronda';

    protected static ?string $navigationLabel = 'Periode';

    public static function getNavigationBadge(): ?string
    {
        return static::getModel()::count();
    }

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\DatePicker::make('start_date')
                    ->required(),
                Forms\Components\DatePicker::make('end_date')
                    ->required(),
                Forms\Components\Toggle::make('is_locked')
                    ->required(),
                Forms\Components\Toggle::make('is_active')
                    ->required(),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\TextColumn::make('name')
                    ->searchable(),
                Tables\Columns\TextColumn::make('start_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\TextColumn::make('end_date')
                    ->date()
                    ->sortable(),
                Tables\Columns\IconColumn::make('is_locked')
                    ->boolean(),
                Tables\Columns\IconColumn::make('is_active')
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
                Action::make('acakJadwal')
                    ->label('Acak Jadwal')
                    ->icon('heroicon-o-rocket-launch')
                    ->color('info')
                    ->requiresConfirmation()
                    ->action(function (RondaPeriode $record, array $data) {
                        app(RondaShuffleService::class)->shuffle($record);

                        Notification::make()
                            ->success()
                            ->title('Berhasil')
                            ->body('Jadwal ronda berhasil diacak!')
                            ->send();
                    }),
                Action::make('generateTermin')
                    ->label('Generate')
                    ->icon('heroicon-m-sparkles')
                    ->color('success')
                    ->form([
                        TextInput::make('hariPerTermin')
                            ->label('Jumlah Hari per Termin')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                    ])
                    ->requiresConfirmation()
                    ->action(function (array $data, RondaPeriode $record) {
                        app(RondaTerminGeneratorService::class)->generate($record, (int) $data['hariPerTermin']);

                        Notification::make()
                            ->title('Berhasil Generate Termin')
                            ->body("Termin untuk periode '{$record->name}' berhasil dibuat.")
                            ->success()
                            ->send();
                    })
                    ->visible(fn (RondaPeriode $record) => $record->is_active),
                Action::make('regenerateTermin')
                    ->label('Regenerate')
                    ->icon('heroicon-m-arrow-path')
                    ->color('danger')
                    ->requiresConfirmation()
                    ->form([
                        TextInput::make('hariPerTermin')
                            ->label('Jumlah Hari per Termin')
                            ->numeric()
                            ->minValue(1)
                            ->required(),
                    ])
                    ->action(function (array $data, RondaPeriode $record) {
                        $record->rondaTermins()->delete(); // hapus semua
                        app(RondaTerminGeneratorService::class)->generate($record, (int) $data['hariPerTermin']);

                        Notification::make()
                            ->title('Termin Diperbarui')
                            ->success()
                            ->send();
                    }),
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
        ];
    }

    public static function getPages(): array
    {
        return [
            'index' => Pages\ListRondaPeriodes::route('/'),
            'create' => Pages\CreateRondaPeriode::route('/create'),
            'edit' => Pages\EditRondaPeriode::route('/{record}/edit'),
        ];
    }
}
