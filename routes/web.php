<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\PengemudiAuthController;

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

// Logout Pengemudi
Route::post('/pengemudi/logout', [PengemudiAuthController::class, 'logout'])
    ->name('pengemudi.logout');