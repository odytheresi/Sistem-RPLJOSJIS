<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;
use App\Http\Controllers\OperatorController; // <-- 1. Jangan lupa diimport di atas

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