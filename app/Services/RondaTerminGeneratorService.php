<?php

namespace App\Services;

use App\Models\RondaPeriode;
use App\Models\RondaTermin;
use Illuminate\Support\Carbon;

class RondaTerminGeneratorService
{
    /**
     * Generate termin berdasarkan periode dan jumlah hari per termin.
     */
    public function generate(RondaPeriode $periode, int $hariPerTermin): void
    {
        $start = Carbon::parse($periode->start_date);
        $end = Carbon::parse($periode->end_date);
        $totalHari = $start->diffInDays($end) + 1;

        $jumlahTermin = intdiv($totalHari, $hariPerTermin);
        $sisaHari = $totalHari % $hariPerTermin;

        $currentStart = $start->copy();
        $index = 1;

        while ($jumlahTermin > 0) {
            $durasi = $hariPerTermin;

            if ($index === 1 && $sisaHari > 0) {
                $durasi += $sisaHari; // Tambahkan sisa hari ke termin pertama
            }

            $terminEnd = $currentStart->copy()->addDays($durasi - 1);

            RondaTermin::create([
                'ronda_periode_id' => $periode->id,
                'name' => "Termin {$index}",
                'start_date' => $currentStart,
                'end_date' => $terminEnd,
                'max_petugas' => 18, // Default, bisa dinamis
            ]);

            $currentStart = $terminEnd->copy()->addDay();
            $index++;
            $jumlahTermin--;
        }
    }
}
