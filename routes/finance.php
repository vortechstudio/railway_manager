<?php

use App\Http\Controllers\Research\ResearchController;
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
Route::prefix('finance')->as('finance.')->group(function () {
    Route::get('/', \App\Http\Controllers\Finance\FinanceController::class)->name('index');
    Route::prefix('bank')->as('bank.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Finance\BanqueController::class, 'index'])->name('index');
        Route::get('/{id}', [\App\Http\Controllers\Finance\BanqueController::class, 'show'])->name('show');
        Route::get('/{id}/emprunt/{emprunt_id}/repay', [\App\Http\Controllers\Finance\BanqueController::class, 'repay'])->name('repay');
    });

    Route::prefix('comptabilite')->as('accounting.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Finance\AccountingController::class, 'index'])->name('index');
    });


});
