<?php

namespace App\Enums;

use Filament\Support\Contracts\HasColor;
use Filament\Support\Contracts\HasLabel;

enum ShiftType: string implements HasColor, HasLabel
{
    case Day = 'Day';
    case Night = 'Night';
    case Mix = 'Mix';

    public function getLabel(): ?string
    {
        return $this->value;
    }

    public function getColor(): string|array|null
    {
        return match ($this) {
            self::Day => 'gray',
            self::Night => 'warning',
            self::Mix => 'success',
        };
    }
}
