<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Pengemudi\PengemudiAuthController;
use App\Http\Controllers\Pengemudi\KendaraanController;
use App\Http\Controllers\Pengemudi\ChargingController;
use App\Http\Controllers\Pengemudi\PembayaranController;

// Route::get('/', function () {
//     return view('welcome');
// });

// =========================
// ROUTE ADMIN
// =========================

Route::get('/admin/login', function () {
    return view('admin.login');
});

Route::get('/admin/dashboard', function () {
    return view('admin.dashboard');
});


// =========================
// ROUTE PENGEMUDI
// =========================

// Register Pengemudi
Route::get('/pengemudi/register', [PengemudiAuthController::class, 'showRegister'])
    ->name('pengemudi.register');

Route::post('/pengemudi/register', [PengemudiAuthController::class, 'register'])
    ->name('pengemudi.register.process');

// Login Pengemudi
Route::get('/pengemudi/login', [PengemudiAuthController::class, 'showLogin'])
    ->name('pengemudi.login');

Route::post('/pengemudi/login', [PengemudiAuthController::class, 'login'])
    ->name('pengemudi.login.process');

// Dashboard Pengemudi
Route::get('/pengemudi/dashboard', function () {
    return view('pengemudi.dashboard');
})
    ->middleware('pengemudi.auth')
    ->name('pengemudi.dashboard');

// Profile Pengemudi
Route::get('/pengemudi/profile', [PengemudiAuthController::class, 'profile'])
    ->middleware('pengemudi.auth')
    ->name('pengemudi.profile');

// Edit Profile Pengemudi
Route::get('/pengemudi/profile/edit', [PengemudiAuthController::class, 'editProfile'])
    ->middleware('pengemudi.auth')
    ->name('pengemudi.profile.edit');

Route::put('/pengemudi/profile', [PengemudiAuthController::class, 'updateProfile'])
    ->middleware('pengemudi.auth')
    ->name('pengemudi.profile.update');

// Logout Pengemudi
Route::post('/pengemudi/logout', [PengemudiAuthController::class, 'logout'])
    ->name('pengemudi.logout');


// =========================
// ROUTE PENGEMUDI
// =========================

Route::middleware('pengemudi.auth')->prefix('pengemudi')->name('pengemudi.')->group(function () {

    // Kendaraan
    Route::get('/kendaraan', [KendaraanController::class, 'index'])
        ->name('kendaraan.index');

    Route::get('/kendaraan/tambah', [KendaraanController::class, 'create'])
        ->name('kendaraan.create');

    Route::post('/kendaraan', [KendaraanController::class, 'store'])
        ->name('kendaraan.store');

    Route::get('/kendaraan/{id}/edit', [KendaraanController::class, 'edit'])
        ->name('kendaraan.edit');

    Route::put('/kendaraan/{id}', [KendaraanController::class, 'update'])
        ->name('kendaraan.update');

    Route::delete('/kendaraan/{id}', [KendaraanController::class, 'destroy'])
        ->name('kendaraan.destroy');

    // Charging
    Route::get('/charging', [ChargingController::class, 'index'])
        ->name('charging.index');
    // Memulai sesi Charging
    Route::post('/charging/mulai', [ChargingController::class, 'start'])
        ->name('charging.start');
    // Mengakhiri sesi Charging
    Route::post('/charging/akhiri', [ChargingController::class, 'end'])
        ->name('charging.end');

    Route::get('/pembayaran', [PembayaranController::class, 'index'])
        ->name('pembayaran.index');
    Route::post('/pembayaran/{id}/bayar', [PembayaranController::class, 'bayar'])
        ->name('pembayaran.bayar');
    Route::get('/pembayaran/{id}/bukti', [PembayaranController::class, 'bukti'])
        ->name('pembayaran.bukti');

    // Route untuk download PDF
    Route::get('/pembayaran/{id}/bukti/pdf', [PembayaranController::class, 'cetakBukti'])
        ->name('pembayaran.bukti.pdf');
});

