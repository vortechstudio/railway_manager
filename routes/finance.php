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
    Route::prefix('bank')->as('bank.')->group(function () {
        Route::get('/', [\App\Http\Controllers\Finance\BanqueController::class, 'index'])->name('index');
    });
});
