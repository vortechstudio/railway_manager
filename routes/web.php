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
    });
});

Route::get('/test', function (Request $request) {
    $ollama = Ollama::agent('
    Tu va agir en tant que bot. Ton but va être de définir de manière aléatoire des incidents suivant des cas spécifiques aux services ferroviaire français.
    - Le résultat doit être au format JSON et uniquement dans ce format car il sera traiter ultérieurement en PHP, pas besoins de message explicative hors du tableau JSON
    - Niveau: de 0 à 3 ou 0 est un cas sans gravité pour la circulation de la rame et 3 est un cas extremement grave immobilisant la rame sur le parcoure.
    - Type d\'incident: Il y à 3 type d\'incident (infrastructure,materiel,humain)
    - Désignation: Le problème/incident actuellement rencontrer sur la voie ou la rame
    - Retarded Time: Le temps de retard estimé suivant le problème. (niveau 0: 2 à 5min / niveau 1: 5 à 10min / niveau 2: 10 à 60min / niveau 3: trajet annulée
    - Note: Une petite note explicative sur le problème et sa résolution probable.
    - Tu doit générer qu\'un seul incident.
    - Essaie d\'alterner entre les trois types d\'incident le plus possible (pas tous le temps le même)

    Voici quelque exemple d\'incident ferroviaire pour le matériel:
    - Collision avec un animal (niveau: 3)
    - Collision contre un obstacle (niveau: 3)
    - Dépassement de vitesse autorisée (niveau: 2)
    - Franchissement d\'un signal carré (niveau: 2)
    - Déraillement (niveau: 3)
    - Pantographes arrachés (niveau: 2)
    - Pantographe sortie de caténaire (niveau: 2)
    - Problème avec les feux de position (niveau: 1)
    - Attelage inopérant ou défectueux (niveau: 1)
    - Bloc de freinage défectueux (niveau: 3)
    - Bloc moteur défectueux (niveau: 2)
    - Bloc commun défectueux (niveau: 2)
    - Bogie moteur défectueux (niveau: 3)
    - Bogie secondaire en défaillance (niveau: 3)
    - Compresseur défectueux (niveau: 3)
    - Alimentation des lumières en voiture défectueuse (niveau: 1)
    - Ventilation en voiture défectueuse (niveau: 1)
    - Chauffage en voiture défectueuse (niveau: 1)
    - Incendie à bord du train (niveau: 3)
    Voici quelque exemple d\'incident ferroviaire pour l\'infrastructure:
    - Déformation de la voie (niveau: 1)
    - Défaillance d\'un aiguillage (niveau: 2)
    - Défaillance d\'un signal carré (niveau: 3)
    - Panne générale de courant (niveau: 3)
    - Caténaire arrachée, défectueuse ou sortie de son logement (niveau: 3)
    - Défaillance d\'un passage à niveau (niveau: 3)
    - Défaillance d\'un système de sécurité (ex: TIV, KVB, etc...) (niveau: 3)
    - Défaillance d\'un système de signalisation (ex: BAL, BAPR, etc...) (niveau: 3)
    - Défaillance d\'un système de contrôle de vitesse (ex: TVM, ETCS, etc...) (niveau: 2)
    Voici quelque exemple d\'incident ferroviaire humains:
    - Accident de personne (niveau: 3)
    - Agression à bord du train (niveau: 2)
    - Activation abusive du signal d\'alarme (niveau: 1)
    - Oubli d\'ouverture / fermeture des portes (niveau: 1)

    Tu peut choisir un type d\'incident parmis ceux-ci en accord avec leurs niveau
    Format de réponse attendue:
    [
        {
            "niveau": 1,
            "type_incident": "infrastructure",
            "designation": "Panne d\'un transformateur entre la ligne Nantes - Cholet",
            "retarded_time": 15,
            "note": "La panne n\'est pas problématique est soit mais peut impacter le traffic du TER 856000."
        }
    ]
    ');

    $response = $ollama->model('llama3')
        ->options(['temperature' => 1.2])
        ->prompt("Ligne Les Sables d'olonne (09:35) - Nantes (11:02) parcourue par le TER 785000 de type électrique ayant actuellement 0min de retard et 65 personne à son bord. Arret: La mothe achard / La roche sur yon / Montaigu Vendée / Clisson")
        ->prompt('La rame est actuellement entre Clisson et Nantes et il est 10:53')
        ->stream(false)
        ->ask();

    dd();
});

Route::get('/maintenance', function () {
    return view('maintenance');
})->name('maintenance');
