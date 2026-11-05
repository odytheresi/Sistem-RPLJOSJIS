<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

use App\Models\User;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ChargingStationController;
use App\Http\Controllers\ChargerController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\KeluhanController;
use App\Http\Controllers\PerbaikanController;

Route::middleware(['auth', 'operator'])
    ->prefix('operator')
    ->name('operator.')
    ->group(function () {

        Route::get('/dashboard', [OperatorController::class, 'index'])
            ->name('dashboard');

        Route::resource('station', ChargingStationController::class);

        Route::resource('charger', ChargerController::class);
        Route::patch('/charger/{charger}/status', [ChargerController::class, 'updateStatus'])
            ->name('charger.status');

        Route::resource('tarif', TarifController::class)->except(['show']);

       Route::get('/keluhan', [KeluhanController::class, 'index'])
        ->name('keluhan.index');

        Route::get('/keluhan/{keluhan}', [KeluhanController::class, 'show'])
        ->name('keluhan.show');

    

        Route::resource('perbaikan', PerbaikanController::class);
    });

// === HANYA UNTUK TES LOKAL, HAPUS SEBELUM PUSH KE GITHUB ===
if (app()->environment('local')) {
    Route::get('/dev-login', function () {
        Auth::login(User::where('email', 'operator@test.com')->firstOrFail());
        return redirect()->route('operator.dashboard');
    });

    // supaya redirect middleware tidak error sebelum halaman login asli dibuat
    Route::get('/login', fn () => redirect('/dev-login'))->name('login');
}