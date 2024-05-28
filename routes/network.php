<?php

use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/
Route::prefix('network')->as('network.')->group(function () {
    Route::get('/', \App\Http\Controllers\Network\NetworkController::class)->name('index');

    Route::prefix('hub')->as('hub.')->group(function () {
        Route::get('buy', [\App\Http\Controllers\Network\HubController::class, 'buy'])->name('buy');
        Route::get('{id}', [\App\Http\Controllers\Network\HubController::class, 'show'])->name('show');
    });

    Route::prefix('line')->as('line.')->group(function () {
        Route::get('{id}', [\App\Http\Controllers\Network\LineController::class, 'show'])->name('show');
    });

    Route::prefix('travel')->as('travel.')->group(function () {
        Route::get('{id}', [\App\Http\Controllers\Network\TravelController::class, 'show'])->name('show');
    });
});
