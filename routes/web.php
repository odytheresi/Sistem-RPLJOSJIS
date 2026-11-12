<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChargerController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\KeluhanController;


Route::get('/', function () {
    return redirect('/login');
});

// Halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Dashboard Operator (Wajib ada agar route('operator.dashboard') tidak error)
Route::get('/operator/dashboard', [OperatorController::class, 'index'])->name('operator.dashboard');

// Halaman Detail Lokasi Stasiun
Route::get('/operator/lokasi_stasiun', [OperatorController::class, 'lokasiStasiun'])->name('operator.lokasi_stasiun');

// ===================== MENU OPERATOR =====================
// Jika ingin membatasi hanya untuk user yang sudah login, tambahkan ->middleware('auth')
// setelah Route::prefix('operator'). Controller keluhan & perbaikan memakai auth()->user()->operator.
Route::prefix('operator')->name('operator.')->group(function () {

    // Tarif
    Route::resource('tarif', TarifController::class)->except('show');

    // Charger (route updateStatus ditulis sebelum resource)
    Route::patch('charger/{charger}/status', [ChargerController::class, 'updateStatus'])
        ->name('charger.updateStatus');
    Route::resource('charger', ChargerController::class);

    // Keluhan: daftar, detail, dan ubah status
    // -> operator.keluhan.index | operator.keluhan.show | operator.keluhan.updateStatus
    Route::patch('keluhan/{keluhan}/status', [KeluhanController::class, 'updateStatus'])
        ->name('keluhan.updateStatus');
    Route::resource('keluhan', KeluhanController::class)->only(['index', 'show']);

    // Maintenance (controller/model memakai nama "perbaikan")
    // URL  : /operator/maintenance, /operator/maintenance/create, /operator/maintenance/{perbaikan}, dst.
    // Nama : operator.perbaikan.index | create | store | show | edit | update | destroy
    Route::resource('maintenance', PerbaikanController::class)
        ->parameters(['maintenance' => 'perbaikan'])
        ->names('perbaikan');
});