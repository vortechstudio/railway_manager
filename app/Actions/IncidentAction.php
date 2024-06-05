<?php

namespace App\Actions;

use App\Models\Railway\Planning\RailwayPlanning;
use Cloudstudio\Ollama\Facades\Ollama;

class IncidentAction
{
    public \Cloudstudio\Ollama\Ollama $ollama;

    public function __construct()
    {
        $this->ollama = Ollama::agent('
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
    }

    public function newIncident(RailwayPlanning $planning)
    {
        $response = $this->ollama->model('llama3')
            ->options(['temperature' => 1.2])
            ->prompt("Ligne {$planning->userRailwayLigne->railwayLigne->start->name} ({$planning->date_depart->format('H:i')}) - {$planning->userRailwayLigne->railwayLigne->end->name} ({$planning->date_arrived->format('H:i')}) parcourue par le {$planning->userRailwayEngine->railwayEngine->type_transport->name} {$planning->userRailwayEngine->number} de type {$planning->userRailwayEngine->railwayEngine->type_energy->value} ayant actuellement {$planning->retarded_time}min de retard et {$planning->passengers()->sum('nb_passengers')} personne à son bord. Arret: {$this->displayStations($planning)}")
            ->stream(false)
            ->ask();

        return \Vortechstudio\Helpers\Facades\Helpers::searchJsonOnString($response['response']);
    }

    public function getAmountReparation(int $niveau)
    {
        return match ($niveau) {
            1 => fake()->randomFloat(2, 100,1500),
            2 => fake()->randomFloat(2, 1501,9999),
            3 => fake()->randomFloat(2, 10000,59999),
        };
    }

    private function displayStations(RailwayPlanning $planning)
    {
        ob_start();
        foreach ($planning->stations as $station):
        ?>
        <?= $station->name; ?>,
        <?php
        endforeach;
        return ob_get_clean();
    }
}
