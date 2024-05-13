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
Route::prefix('auth')->as('auth.')->group(function () {
    Route::get('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
    Route::get('{provider}/redirect', [\App\Http\Controllers\AuthController::class, 'redirect'])->name('redirect');
    Route::get('{provider}/callback', [\App\Http\Controllers\AuthController::class, 'callback'])->name('callback');
    Route::get('{provider}/setup-account/{email}', [\App\Http\Controllers\AuthController::class, 'setupAccount'])->name('setup-account');
    Route::post('{provider}/setup-account/{email}', [\App\Http\Controllers\AuthController::class, 'setupAccountSubmit'])->name('setup-account.submit');

    Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
    Route::post('password-confirm', [\App\Http\Controllers\AuthController::class, 'confirmPassword'])
        ->name('confirm-password')
        ->middleware(['auth', 'throttle:6,1']);

    Route::get('install', [\App\Http\Controllers\AuthController::class, 'install'])->name('install');
    Route::post('install', [\App\Http\Controllers\AuthController::class, 'installSubmit'])->name('install.submit');
});


Route::get('password-confirm', [\App\Http\Controllers\AuthController::class, 'confirmPasswordForm'])
    ->name('password.confirm')
    ->middleware('auth');

Route::get('/test', function () {
    auth()->user()->railway->addReputation('engine', null);
});

Route::middleware(['auth', 'install'])->group(function () {
    Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');
    Route::get('/shop')->name('shop');
    Route::post('/push', \App\Http\Controllers\PushSubscriptionController::class);
    include('account.php');
});
