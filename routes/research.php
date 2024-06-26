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
Route::prefix('research')->as('research.')->group(function () {
    Route::get('/', [ResearchController::class, 'index'])->name('index');
    Route::get('/infrastructure', [ResearchController::class, 'infrastructure'])->name('infrastructure');
    Route::get('/train', [ResearchController::class, 'train'])->name('train');
});
