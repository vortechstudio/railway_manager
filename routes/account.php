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
Route::prefix('account')->as('account.')->group(function () {
    Route::get('/')->name('profil');

    Route::prefix('mailbox')->as('mailbox.')->group(function () {
        Route::get('/')->name('inbox');
    });
});
