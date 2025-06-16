<?php

namespace App\Filament\Resources;

use App\Filament\Resources\UserResource\Pages;
use App\Models\User;
use Filament\Forms;
use Filament\Forms\Components\Select;
use Filament\Forms\Components\TextInput;
use Filament\Forms\Form;
use Filament\Infolists\Components\Section;
use Filament\Infolists\Components\TextEntry;
use Filament\Infolists\Infolist;
use Filament\Resources\Resource;
use Filament\Support\Enums\FontWeight;
use Filament\Tables;
use Filament\Tables\Actions\Action;
use Filament\Tables\Enums\FiltersLayout;
use Filament\Tables\Filters\SelectFilter;
use Filament\Tables\Table;

class UserResource extends Resource
{
    protected static ?string $model = User::class;

    protected static ?string $navigationIcon = 'heroicon-o-user-circle';

    protected static ?string $navigationGroup = 'Settings';

    protected static ?int $navigationSort = 1;

    public static function form(Form $form): Form
    {
        return $form
            ->schema([
                Forms\Components\TextInput::make('name')
                    ->required()
                    ->maxLength(255),
                Forms\Components\TextInput::make('email')
                    ->email()
                    ->required()
                    ->maxLength(255),
                Forms\Components\DateTimePicker::make('email_verified_at'),
                Forms\Components\TextInput::make('password')
                    ->password()
                    ->required()
                    ->maxLength(255),
            ]);
    }

    public static function table(Table $table): Table
    {
        return $table
            ->columns([
                Tables\Columns\Layout\Split::make([
                    Tables\Columns\ImageColumn::make('avatar_url')
                        ->circular()
                        ->grow(false)
                        ->getStateUsing(fn ($record) => $record->avatar_url
                            ? $record->avatar_url
                            : 'https://ui-avatars.com/api/?name='.urlencode($record->name)),
                    Tables\Columns\TextColumn::make('name')
                        ->weight(FontWeight::Bold),
                    Tables\Columns\Layout\Stack::make([
                        Tables\Columns\TextColumn::make('roles.name')
                            ->icon('heroicon-o-shield-check')
                            ->grow(false),
                        Tables\Columns\TextColumn::make('email')
                            ->icon('heroicon-m-envelope')
                            ->grow(false),
                    ])->alignStart()->visibleFrom('lg')->space(1),
                ]),
            ])
            ->filters([
                Tables\Filters\Filter::make('name')
                    ->form([
                        TextInput::make('name')
                            ->placeholder('Search by name'),
                    ])
                    ->query(fn ($query, $data) => $query->where('name', 'like', "%{$data['name']}%")),
                Tables\Filters\Filter::make('email')
                    ->form([
                        TextInput::make('email')
                            ->placeholder('Search by email'),
                    ])
                    ->query(fn ($query, $data) => $query->where('email', 'like', "%{$data['email']}%")),
                SelectFilter::make('roles')
                    ->relationship('roles', 'name')
                    ->multiple()
                    ->preload(),

            ], layout: FiltersLayout::AboveContent)
            ->actions([
                Tables\Actions\ViewAction::make(),
                Tables\Actions\EditAction::make(),
                Action::make('Set Role')
                    ->icon('heroicon-m-adjustments-vertical')
                    ->color('info')
                    ->form([
                        Select::make('role')
                            ->relationship('roles', 'name')
                            ->multiple()
                            ->required()
                            ->searchable()
                            ->preload()
                            ->optionsLimit(10)
                            ->getOptionLabelFromRecordUsing(fn ($record) => $record->name),
                    ]),
                Tables\Actions\DeleteAction::make(),
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
            'index' => Pages\ListUsers::route('/'),
            'create' => Pages\CreateUser::route('/create'),
            'view' => Pages\ViewUser::route('/{record}'),
            'edit' => Pages\EditUser::route('/{record}/edit'),
        ];
    }

    public static function infolist(Infolist $infolist): Infolist
    {
        return $infolist
            ->schema([
                Section::make('User Information')->schema([
                    TextEntry::make('name'),
                    TextEntry::make('email'),
                ]),
            ]);
    }
}
