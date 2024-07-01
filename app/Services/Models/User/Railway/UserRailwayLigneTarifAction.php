<?php

namespace App\Services\Models\User\Railway;

use App\Models\Railway\Config\RailwaySetting;
use App\Models\User\Railway\UserRailwayLigne;
use App\Models\User\Railway\UserRailwayLigneTarif;
use Carbon\Carbon;

class UserRailwayLigneTarifAction
{
    public function __construct(private ?UserRailwayLigneTarif $ligneTarif, private ?UserRailwayLigne $ligne)
    {
    }

    public function baseCoast()
    {
        $price_kilometer = RailwaySetting::where('name', 'price_kilometer')->first()->value;
        return ($price_kilometer * $this->ligne->railwayLigne->distance) / 10;
    }

    public function electricityCoast()
    {
        $price_electricity = RailwaySetting::where('name', 'price_electricity')->first()->value;
        return $price_electricity * $this->ligne->railwayLigne->distance / 10;
    }

    public function infraCoast()
    {
        $levelCoef = $this->ligne->level * 1.2;
        return $this->baseCoast() * $levelCoef / 10;
    }

    public function demandeCoast(string $type_price)
    {
        if($type_price == 'first') {
            $latestDemande = $this->ligne->tarifs()->whereDate('date_tarif', Carbon::yesterday())
                ->where('type_tarif', 'first')->first()->demande ?? 1;
        } else {
            $latestDemande = $this->ligne->tarifs()->whereDate('date_tarif', Carbon::yesterday())
                ->where('type_tarif', 'unique')->orWhere('type_tarif', 'second')->first()->demande ?? 1;
        }

        $range = $this->ligne->max_passengers - $this->ligne->min_passengers;
        $currentDemande = $latestDemande + $range / 2;
        $change = ($currentDemande - $latestDemande) / $latestDemande * 100;

        if ($change <= -33) {
            $coef = -0.5;
        } elseif ($change <= 33) {
            $coef = 0;
        } else {
            $coef = 0.5;
        }

        return $this->baseCoast() * $coef;
    }

    public function calculatePriceDaily(string $type_tarif)
    {
        $base = $this->baseCoast();
        $electricity = $this->electricityCoast();
        $infra = $this->infraCoast();
        $demande = $this->demandeCoast($type_tarif);

        if($type_tarif == 'first') {
            return ($base + $electricity + $infra + $demande) * 80 / 100;
        } else {
            return ($base + $electricity + $infra + $demande) * 40 / 100;
        }
    }
}
