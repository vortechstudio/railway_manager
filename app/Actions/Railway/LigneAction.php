<?php

namespace App\Actions\Railway;

use App\Models\Railway\Ligne\RailwayLigne;

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
}
