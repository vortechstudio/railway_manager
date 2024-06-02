<?php

namespace App\Services\Models\Railway\Engine;

use App\Models\Railway\Engine\RailwayEnginePrice;

class RailwayEnginePriceAction
{
    public function __construct(private RailwayEnginePrice $price)
    {
    }

    public function calcCaution()
    {
        return floatval($this->price->achat - ($this->price->achat * 60 / 100));
    }

    public function calcFrais(int $durationSemaine)
    {
        $timeMaintenance = (new RailwayEngineTechnicalAction($this->price->engine->technical))->calcDurationMaintenancePrev();
        $calc = (($this->price->maintenance * $timeMaintenance->diffInHours(now()->startOfDay())) * $durationSemaine) / 5;
        return floatval($calc);
    }
}
