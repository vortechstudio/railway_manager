<?php

namespace App\Actions\Railway;

use App\Models\Railway\Ligne\RailwayLigne;
use App\Models\User\Railway\UserRailwayLigne;

class LigneAction
{
    /**
     * Calculate the price based on the given RailwayLigne object.
     *
     * @param  RailwayLigne  $ligne  The RailwayLigne object to calculate the price.
     * @return float|int The calculated price.
     */
    public function calculatePrice(RailwayLigne $ligne): float|int
    {
        return ($ligne->distance * $ligne->time_min) * $ligne->stations()->count();
    }

    public function defineTarifUserLigne(UserRailwayLigne $ligne)
    {
        $price_kilometer = \App\Models\Railway\Config\RailwaySetting::where('name', 'price_kilometer')->first()->value;
        $price_electrique = \App\Models\Railway\Config\RailwaySetting::where('name', 'price_electricity')->first()->value;
        $distance = $ligne->railwayLigne->distance;
        $calculDistance = $price_kilometer * $distance;
        $coutExplotation = ($price_electrique + ($ligne->userRailwayEngine->railwayEngine->price->maintenance / $distance)) / ($ligne->user->railway_company->frais);
        $baseTarif = ($calculDistance + $coutExplotation) * $ligne->user->railway_company->subvention / 100;
        $offre = $ligne->userRailwayEngine->railwayEngine->technical->nb_marchandise;
        $countInfrastructure = ($ligne->userRailwayHub->railwayHub->taxe_hub_price / $offre);
        $subTotal = ($baseTarif + $countInfrastructure) / $ligne->user->railway_company->tarification;
        $price_second = $subTotal * 1.25;
        $price_first = $subTotal * 1.45;

        return collect([
            'first' => $price_first,
            'second' => $price_second,
        ]);
    }
}
