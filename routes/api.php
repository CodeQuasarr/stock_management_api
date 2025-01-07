<?php

use App\Http\Controllers\Api\V1\Stocks\SotckStatisticController;
use App\Http\Controllers\Api\V1\Stocks\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::apiResource('dashboard', Das::class);

    Route::prefix('stocks')->group(function () {
        Route::get('statistics', [SotckStatisticController::class, 'index']);

        Route::prefix('{productCode}')->group(function () {
            Route::get('days-in-stock', [StockController::class, 'getDaysInStock']);
            Route::get('mouvements', [StockController::class, 'getProductMovements']);
        });

    });
});
