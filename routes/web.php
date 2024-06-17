<?php

use App\Services\RailwayService;
use Illuminate\Http\Request;
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
Route::middleware(['nolocked'])->group(function() {
    Route::prefix('auth')->as('auth.')->group(function () {
        Route::get('login', [\App\Http\Controllers\AuthController::class, 'login'])->name('login');
        Route::get('{provider}/redirect', [\App\Http\Controllers\AuthController::class, 'redirect'])->name('redirect');
        Route::get('{provider}/callback', [\App\Http\Controllers\AuthController::class, 'callback'])->name('callback');
        Route::get('{provider}/setup-account/{email}', [\App\Http\Controllers\AuthController::class, 'setupAccount'])->name('setup-account');

        Route::get('logout', [\App\Http\Controllers\AuthController::class, 'logout'])->name('logout');
        Route::post('password-confirm', [\App\Http\Controllers\AuthController::class, 'confirmPassword'])
            ->name('confirm-password')
            ->middleware(['auth', 'throttle:6,1']);

        Route::get('install', [\App\Http\Controllers\AuthController::class, 'install'])->name('install');
    });


    Route::get('password-confirm', [\App\Http\Controllers\AuthController::class, 'confirmPasswordForm'])
        ->name('password.confirm')
        ->middleware('auth');

    Route::middleware(['auth', 'install'])->group(function () {
        Route::get('/', \App\Http\Controllers\HomeController::class)->name('home');
        Route::post('/push', \App\Http\Controllers\PushSubscriptionController::class);
        Route::get('/news', \App\Http\Controllers\NewsController::class)->name('news');

        Route::prefix('shop')->as('shop.')->group(function () {
            Route::get('/', [\App\Http\Controllers\ShopController::class, 'index'])->name('index');
        });

        Route::prefix('trophy')->as('trophy.')->group(function () {
            Route::get('/', [\App\Http\Controllers\TrophyController::class, 'index'])->name('index');
            Route::get('{sector}', [\App\Http\Controllers\TrophyController::class, 'show'])->name('show');
        });

        Route::get('services', \App\Http\Controllers\ServiceController::class)->name('services');

        include('account.php');
        include('network.php');
        include('materiel.php');
        include('company.php');
        include('research.php');
    });
});

Route::get('/test', function (Request $request) {
    $ligne = \App\Models\User\Railway\UserRailwayLigne::find(1);
    dd((new \App\Actions\Intelligency())->defineDemandeTarifs($ligne));

});

Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance');
