<?php
use App\Http\Controllers\Api\AdminController;
use App\Http\Controllers\Api\AdminAuthController;
use App\Http\Controllers\Api\MeController;
use App\Http\Controllers\Api\StationApiController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::post('login', [AdminAuthController::class, 'login']);

// tambahan operator
Route::get('/stations/{id}', [StationApiController::class, 'show']);

// NFR-01: semua route di bawah wajib token valid + sesi masih aktif
Route::middleware(['auth:sanctum', 'sesi.aktif'])->group(function () {
    Route::post('logout', [AdminAuthController::class, 'logout']);
    Route::get('user', fn (Request $r) => $r->user());
    Route::get('me/hak-akses', [MeController::class, 'hakAkses']);

    // NFR-01: tiap route admin dicek fitur + aksinya
    Route::prefix('admin')->group(function () {
        Route::get('ringkasan', [AdminController::class, 'ringkasan'])->middleware('akses:dashboard,lihat');

        // FR-012: daftar akun + aktif/nonaktifkan akun (role tidak diubah lewat UI)
        Route::get('user',             [AdminController::class, 'user'])->middleware('akses:manajemen_user,lihat');
        Route::put('user/{id}/status', [AdminController::class, 'ubahStatusUser'])->middleware('akses:manajemen_user,ubah');

        Route::get('laporan',     [AdminController::class, 'laporan'])->middleware('akses:laporan,lihat');
        Route::get('laporan/pdf', [AdminController::class, 'laporanPdf'])->middleware('akses:laporan,lihat');

        Route::get('audit-log', [AdminController::class, 'auditLog'])->middleware('akses:audit_log,lihat');
    });
});