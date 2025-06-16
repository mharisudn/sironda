<?php

namespace App\Http\Controllers;

use App\Models\PollingCode;
use App\Models\PollingSubmission;
use App\Models\RondaPeriode;
use Illuminate\Http\Request;

class PollingController extends Controller
{
    public function index()
    {
        return view('pages.polling.index');
    }

    public function validateCode(Request $request)
    {
        $request->validate([
            'code' => 'required|exists:polling_codes,code',
        ]);

        return redirect()->route('polling.form', ['code' => $request->code]);
    }

    public function form($code)
    {
        $pollingCode = PollingCode::where('code', $code)->firstOrFail();
        $periode = RondaPeriode::where('is_active', true)->where('is_locked', false)->latest()->first();

        if (! $periode) {
            return view('pages.polling.closed');
        }

        $termins = $periode->rondaTermins;
        $selected = $pollingCode->pollingSubmissions()->pluck('ronda_termin_id')->toArray();

        return view('pages.polling.form', compact('pollingCode', 'termins', 'selected'));
    }

    public function submit(Request $request, $code)
    {
        $pollingCode = PollingCode::where('code', $code)->firstOrFail();

        $request->validate([
            'termins' => ['required', 'array', 'min:1', 'max:2'],
        ]);

        $periode = RondaPeriode::where('is_active', true)->where('is_locked', false)->latest()->firstOrFail();
        $validTerminIds = $periode->rondaTermins->pluck('id')->toArray();

        // Filter hanya termin dari periode aktif
        $selectedTerminIds = array_filter($request->termins, fn ($id) => in_array($id, $validTerminIds));

        // Hapus yang lama dulu
        PollingSubmission::where('polling_code_id', $pollingCode->id)
            ->whereIn('ronda_termin_id', $validTerminIds)
            ->delete();

        foreach ($selectedTerminIds as $terminId) {
            PollingSubmission::create([
                'polling_code_id' => $pollingCode->id,
                'ronda_termin_id' => $terminId,
                'submitted_at' => now(),
            ]);
        }

        return redirect()->route('polling.form', ['code' => $code])
            ->with('success', 'Pilihan ronda kamu berhasil disimpan.');
    }
}
