<?php

namespace App\Actions;

use App\Models\User\Railway\UserRailwayLigne;
use Ollama;

class Intelligency
{
    /**
     * Calculates the demand for tariffs on a railway journey based on the given information.
     *
     * @param  UserRailwayLigne  $ligne  The user's railway line.
     * @return int The rounded demand value.
     */
    public function defineDemandeTarifs(UserRailwayLigne $ligne): int
    {
        $data = collect();

        $data->push([
            'ligne' => $ligne->railwayLigne,
            'gare_central' => $ligne->userRailwayHub->railwayHub->gare,
            'ratio_multiplicateur_offre' => $ligne->user->railway_company->tarification,
            'nb_arret' => $ligne->railwayLigne->stations()->count(),
            'tarifs' => $ligne->tarifs,
            'engine' => [
                'ligne_engine' => $ligne->userRailwayEngine,
                'engine' => $ligne->userRailwayEngine->railwayEngine()->with('technical', 'price')->first(),
            ],
            'settings' => \App\Models\Railway\Config\RailwaySetting::all(),
        ]);
        $ollama = Ollama::agent('
    Tu agit en temps que bot assistant dans la régulation ferroviaire français.
    Suivant le principe fondamental de l\'offre et de la demande (OD) et en partant des informations qui va être transmis, je veux que tu me donne la valeur arrondie à l\'unité de la demande effective sur le trajet dans un tableau JSON sans autre message.
    Voici les informations que tu doit utiliser dans ton calcule:
    - Prix du trajet
    - Durée du trajet
    - Distance
    - La formule du cout energétique est la suivante: Coût énergétique du trajet = distance × prix kilomètre + (duree du trajet / 60) × (prix electricité ou gasoil suivant le type d\'énergie de la rame / ratio_division_frais)
    - Coût total du trajet = coût énergétique + coûts affilier
    - demande effective = (offre * ratio_multiplicateur_offre) × (1 - (coût total / prix du trajet))
    - Retourne moi la valeur dans un tableau JSON: [{"demande": resultat}] et uniquement ce tableau
    ');
        $response = $ollama->prompt($data->toJson())->model('llama3')
            ->stream(false)
            ->ask();

        return intval(round(\Vortechstudio\Helpers\Facades\Helpers::searchJsonOnString($response['response'])['demande'], 0, PHP_ROUND_HALF_UP));
    }
}
