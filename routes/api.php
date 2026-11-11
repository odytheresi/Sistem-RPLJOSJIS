<?php

use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AuthController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\KonfigSistemController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AuthController::class, 'login']);

// NFR-01: semua route di bawah wajib token valid + sesi masih aktif
Route::middleware(['auth:sanctum', 'sesi.aktif'])->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
    Route::get('user', fn (Request $r) => $r->user());
    Route::get('me/hak-akses', [MeController::class, 'hakAkses']);

    // NFR-01: tiap route admin dicek fitur + aksinya
    Route::prefix('admin')->group(function () {
        Route::get('ringkasan', [AdminController::class, 'ringkasan'])->middleware('akses:dashboard,lihat');

        Route::get('user',           [AdminController::class, 'user'])->middleware('akses:manajemen_user,lihat');
        Route::put('user/{id}/role', [AdminController::class, 'ubahRoleUser'])->middleware('akses:manajemen_user,ubah');

        Route::get('role',                [AdminController::class, 'role'])->middleware('akses:role_hak_akses,lihat');
        Route::get('role/{id}/hak-akses', [AdminController::class, 'hakAksesRole'])->middleware('akses:role_hak_akses,lihat');
        Route::put('role/{id}/hak-akses', [AdminController::class, 'simpanHakAkses'])->middleware('akses:role_hak_akses,ubah');
        Route::put('role/{id}/status',    [AdminController::class, 'ubahStatusRole'])->middleware('akses:role_hak_akses,ubah');

          Route::get('konfigurasi', [KonfigSistemController::class, 'index'])
        ->middleware('akses:konfigurasi_sistem,lihat');

        Route::put('konfigurasi/{id}', [KonfigSistemController::class, 'update'])
            ->middleware('akses:konfigurasi_sistem,ubah');

        Route::get('laporan', [AdminController::class, 'laporan'])
            ->middleware('akses:laporan,lihat');

        Route::get('laporan/csv', [AdminController::class, 'laporanCsv'])
            ->middleware('akses:laporan,lihat');

        Route::get('audit-log', [AdminController::class, 'auditLog'])->middleware('akses:audit_log,lihat');

        // konfigurasi & notifikasi: menyusul setelah struktur tabelnya jelas
    });
});