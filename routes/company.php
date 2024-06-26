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
Route::prefix('company')->as('company.')->group(function () {
    Route::get('/', \App\Http\Controllers\Company\CompanyController::class)->name('index');
    Route::get('/profile', \App\Http\Controllers\Company\ProfilController::class)->name('profil');
    Route::get('/rank', \App\Http\Controllers\Company\RankController::class)->name('rank');
});

