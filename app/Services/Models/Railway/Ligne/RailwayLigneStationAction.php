<?php

namespace App\Services\Models\Railway\Ligne;

use App\Models\Railway\Ligne\RailwayLigneStation;

class RailwayLigneStationAction
{
    public function __construct(private RailwayLigneStation $station)
    {
    }

    public function timeStopStation()
    {
        return match ($this->station->gare->type->value) {
            'large', 'terminus' => rand(4, 10),
            'medium' => rand(1, 3),
            'small', 'halte' => 1
        };
    }
}
