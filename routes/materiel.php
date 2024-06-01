<?php

use App\Http\Controllers\Materiel\TrainController;
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
Route::prefix('train')->as('train.')->group(function () {
    Route::get('buy', [TrainController::class, 'buy'])->name('buy');
    Route::get('buy/checkout', [TrainController::class, 'checkout'])->name('checkout');
    Route::get('buy/rental', [TrainController::class, 'rental'])->name('rental');
});
