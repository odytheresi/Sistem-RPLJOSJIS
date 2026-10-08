<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\StationApiController;

// Endpoint API untuk mengambil data detail stasiun, charger, konektor, dan tarif dalam format JSON
Route::get('/stations/{id}', [StationApiController::class, 'show']);