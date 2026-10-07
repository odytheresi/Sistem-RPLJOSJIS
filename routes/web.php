<?php

use App\Http\Controllers\OperatorController;
use App\Http\Controllers\ChargingStationController;
use App\Http\Controllers\ChargerController;
use App\Http\Controllers\TarifController;
use App\Http\Controllers\TipeKonektorController;

Route::prefix('operator')->name('operator.')->group(function () {

    
    Route::get('/dashboard', [
        OperatorController::class,
        'index'
    ])->name('dashboard');


    
    Route::resource(
        'station',
        ChargingStationController::class
    );


    
    Route::resource(
        'charger',
        ChargerController::class
    );


    
    Route::resource(
        'tarif',
        TarifController::class
    );


    
    Route::resource(
        'konektor',
        TipeKonektorController::class
    );
});

