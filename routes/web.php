<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthController;


Route::get('/', function () {
    return redirect('/login');
});

// Halaman login
Route::get('/login', [AuthController::class, 'showLoginForm'])->name('login');
Route::post('/login', [AuthController::class, 'login']);

// Logout
Route::post('/logout', [AuthController::class, 'logout'])->name('logout');

// Halaman Dashboard yang dijaga session manual
Route::get('/dashboard', function () {
    if (!session()->has('user_id')) {
        return redirect('/login');
    }
    return view('dashboard');
});

// Halaman Dashboard Operator (juga dijaga session)
Route::get('/operator/dashboard', function () {
    if (!session()->has('user_id')) {
        return redirect('/login');
    }
    return view('operator.dashboard');
});

Route::get('/stations/{id}/view', function ($id) {
    return view('operator.lokasi_stasiun', ['id' => $id]);
});