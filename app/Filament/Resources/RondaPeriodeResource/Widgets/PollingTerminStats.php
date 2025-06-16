<?php

namespace App\Filament\Resources\RondaPeriodeResource\Widgets;

use App\Models\PollingSubmission;
use App\Models\RondaPeriode;
use Filament\Widgets\StatsOverviewWidget as BaseWidget;
use Filament\Widgets\StatsOverviewWidget\Card;

class PollingTerminStats extends BaseWidget
{
    protected function getCards(): array
    {
        $periode = RondaPeriode::where('is_active', true)->latest()->first();
        if (! $periode) {
            return [];
        }

        $cards = [];

        foreach ($periode->rondaTermins as $termin) {
            $first = PollingSubmission::where('ronda_termin_id', $termin->id)
                ->where('sort', operator: 1)
                ->distinct('polling_code_id')
                ->count('polling_code_id');

            $second = PollingSubmission::where('ronda_termin_id', $termin->id)
                ->where('sort', 2)
                ->distinct('polling_code_id')
                ->count('polling_code_id');

            $cards[] = Card::make(
                $termin->name,
                $first + $second
            )
                ->description("🥇 $first | 🥈 $second")
                ->descriptionIcon('heroicon-o-user-group');
        }

        return $cards;
    }
}
