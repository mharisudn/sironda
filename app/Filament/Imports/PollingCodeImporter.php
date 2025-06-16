<?php

namespace App\Filament\Imports;

use App\Enums\ShiftType;
use App\Models\PollingCode;
use Filament\Actions\Imports\ImportColumn;
use Filament\Actions\Imports\Importer;
use Filament\Actions\Imports\Models\Import;
use Illuminate\Support\Str;
use Illuminate\Validation\Rules\Enum;

class PollingCodeImporter extends Importer
{
    protected static ?string $model = PollingCode::class;

    protected function beforeCreate(): void
    {
        $this->record->code = $this->generateUniqueCode();
    }

    private function generateUniqueCode(): string
    {
        do {
            $generated = strtolower(Str::random(6));
        } while (PollingCode::where('code', $generated)->exists());

        return $generated;
    }

    public static function getColumns(): array
    {
        return [
            ImportColumn::make('name')
                ->requiredMapping()
                ->rules(['required', 'max:255']),

            ImportColumn::make('shift_type')
                ->rules(['nullable', new Enum(ShiftType::class)]),

            ImportColumn::make('is_leader')
                ->boolean(),
        ];
    }

    public function resolveRecord(): ?PollingCode
    {
        return new PollingCode([
            'name' => $this->data['name'],
            'shift_type' => ! empty($this->data['shift_type'])
            ? ShiftType::tryFrom($this->data['shift_type'])
            : ShiftType::Mix->value,
            'is_leader' => $this->data['is_leader'] ?? false,

        ]);
    }

    public static function getCompletedNotificationBody(Import $import): string
    {
        $body = 'Your polling code import has completed and '.number_format($import->successful_rows).' '.str('row')->plural($import->successful_rows).' imported.';

        if ($failedRowsCount = $import->getFailedRowsCount()) {
            $body .= ' '.number_format($failedRowsCount).' '.str('row')->plural($failedRowsCount).' failed to import.';
        }

        return $body;
    }
}
