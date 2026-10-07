<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\AuthController;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::post('login', [AuthController::class, 'login']);

Route::middleware('auth:sanctum')->group(function () {
    Route::post('logout', [AuthController::class, 'logout']);
});

Route::middleware(['auth:sanctum', 'akses:manajemen_user,lihat'])
    ->get('/test/admin', function () {
        return response()->json([
            'message' => 'Akses Admin berhasil.',
        ]);
    });

Route::middleware(['auth:sanctum', 'akses:charger,lihat'])
    ->get('/test/operator', function () {
        return response()->json([
            'message' => 'Akses Operator berhasil.',
        ]);
    });

Route::middleware(['auth:sanctum', 'akses:kendaraan,lihat'])
    ->get('/test/pengemudi', function () {
        return response()->json([
            'message' => 'Akses Pengemudi berhasil.',
        ]);
    });
