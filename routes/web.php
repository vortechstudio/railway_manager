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

        include('account.php');
        include('network.php');
        include('materiel.php');
    });
});

Route::get('/test', function (Request $request) {
    $engine = \App\Models\Railway\Engine\RailwayEngine::find(6);
    $hub = \App\Models\User\Railway\UserRailwayHub::with('railwayHub', 'userRailwayEngine')->find(1);
    $data = collect([
        'materiel_roulant' => $engine->name,
        'type_engine' => $engine->type_transport->value,
        'hub_affilier' => $hub->railwayHub->gare->name,
        'other_engines' => $hub->userRailwayEngine
    ])->toJson();
    $ollama = Ollama::agent("
    Tu doit agir comme un agent de regulation du traffic ferroviaires français.
    Ton role va être de définir le code mission de la rame suivant le code SNCF et de me le retourner dans un entier absolue et suivant les critères suivant:
    - Les codes missions chez la SNCF sont uniquement des chiffres.
    - Prend en compte le type de transport (type_transport) de la rame (TER,TGV,Intercité,etc...).
    - Prend également en compte le hub d'attache de la rame (ex: Nantes, Lyon, etc,...) en recherchant la région, il servira pour les 2 premiers chiffre en cas de TER ou des Intercités
    - Outre les TGV qui ont 4 chiffres, les TER/Intercité/other ont 6 chiffres
    - Prend également attention aux rames déjà présente avec leurs numéro, le numéro de mission doit être unique.
    - Voici un exemple de code propre:
    - TER: les deux premier chiffre correspond au département du hub / les 4 seconds sont aléatoire mais unique
    - TGV: les deux premier chiffre sont obligatoirement 80 / les deux autres aléatoire mais unique
    - INTERCITE: les deux premiers chiffres correspond au département du HUB / les 4 seconds sont aléatoire mais unique
    - TRAM: Le code mission se compose comme suis: 3 lettres - 5 chiffre (les trois lettres corresponde aux trois premiere lettre du hub / les 5 chiffres aléatoire mais unique)
    - METRO: Tu doit te baser sur la structure du métro parisien de la RATP
    - OTHER: Comme bon te semble mais doit faire entre 5 et 6 chiffre maximum
    -> Retour JSON Obligatoirement attendue: [{'mission_code': XXXXXXX}]
    ");

    $response = $ollama->prompt($data)
        ->model('llama3')
        ->ask();

    dd(\Vortechstudio\Helpers\Facades\Helpers::searchJsonOnString($response['response']));

});

Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance');
