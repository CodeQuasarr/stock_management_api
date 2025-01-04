<?php

use App\Http\Controllers\Api\V1\Stocks\SotckStatisticController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

Route::get('/user', function (Request $request) {
    return $request->user();
})->middleware('auth:sanctum');

Route::prefix('v1')->group(function () {
    Route::prefix('stocks')->group(function () {
        Route::get('statistics', [SotckStatisticController::class, 'index']);
    });
});
