<?php

use App\Livewire\PollingForm;
use App\Livewire\RondaSchedule;
use App\Livewire\SubmitPollingCode;
use Illuminate\Support\Facades\Route;

Route::get('/schedule', RondaSchedule::class)->name('ronda.schedule');

Route::get('/polling', SubmitPollingCode::class)->name('polling.code');
Route::get('/polling/{code}', PollingForm::class)->name('polling.form');
