<?php

use App\Http\Controllers\Api\V1\Stocks\StockStatisticController;
use App\Http\Controllers\Api\V1\Stocks\StockController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {

    Route::prefix('stocks')->group(function () {
        Route::get('statistics', [StockStatisticController::class, 'index']);
        Route::get('{productCode}/movements', [StockController::class, 'getProductMovements']);
        Route::get('/{productCode}/days-in-stock', [StockController::class, 'getDaysInStock']);
    });

    Route::apiResource('stocks', StockController::class);
});
