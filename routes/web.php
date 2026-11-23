<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\ChargerController;
use App\Http\Controllers\KeluhanController;
use App\Http\Controllers\OperatorController;
use App\Http\Controllers\PerbaikanController;
use App\Http\Controllers\TarifController;
use Illuminate\Support\Facades\Route;

// Halaman awal: arahkan ke login
Route::get('/', function () {
    return redirect('/login');
});

// ===================== ADMIN =====================
Route::redirect('/admin', '/admin/dashboard');

Route::view('/admin/login',     'admin.login');
Route::view('/admin/dashboard', 'admin.dashboard');
Route::view('/admin/laporan',   'admin.laporan');
Route::view('/admin/audit-log', 'admin.audit-log');

// ===================== LOGIN =====================
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// ===================== OPERATOR (wajib login + role operator) =====================
Route::middleware(['auth', 'cekrole:operator'])
    ->prefix('operator')
    ->name('operator.')
    ->group(function () {

        // Dashboard & lokasi stasiun
        Route::get('dashboard', [OperatorController::class, 'index'])
            ->name('dashboard');
        Route::get('lokasi_stasiun', [OperatorController::class, 'lokasiStasiun'])
            ->name('lokasi_stasiun');

        // Tarif
        Route::resource('tarif', TarifController::class)->except('show');

        // Charger (route updateStatus ditulis sebelum resource)
        Route::patch('charger/{charger}/status', [ChargerController::class, 'updateStatus'])
            ->name('charger.updateStatus');
        Route::resource('charger', ChargerController::class);

        // Keluhan: daftar, detail, dan ubah status
        Route::patch('keluhan/{keluhan}/status', [KeluhanController::class, 'updateStatus'])
            ->name('keluhan.updateStatus');
        Route::resource('keluhan', KeluhanController::class)->only(['index', 'show']);

        // Maintenance (controller/model memakai nama "perbaikan")
        Route::resource('maintenance', PerbaikanController::class)
            ->parameters(['maintenance' => 'perbaikan'])
            ->names('perbaikan');
    });