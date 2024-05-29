<?php

namespace App\Services\Models\Railway\Gare;

use App\Models\Railway\Gare\RailwayGare;

class GareAction
{
    public function __construct(private RailwayGare $gare)
    {
    }

    public function getSumFirstPassenger(): float|int
    {
        return $this->calculate(20);
    }

    public function getSumSecondPassenger(): float|int
    {
        return $this->calculate(80);
    }

    public function calcNbSlotCommerce(): int
    {
        $confort = auth()->user()->railway_company->confort ?? 1;
        return $this->calculate(50 * $confort);
    }

    public function calcNbSlotPublicite(): int
    {
        $distraction = auth()->user()->railway_company->distraction ?? 1;
        return $this->calculate(25 * $distraction);
    }

    public function calcNbSlotParking(): int
    {
        $confort = auth()->user()->railway_company->confort ?? 1;
        return $this->calculate(10 * $confort);
    }

    private function calculate(int $factor): int
    {
        $distraction = auth()->user()->railway_company->distraction ?? 1;
        $basVal = $this->gare->freq_base * $distraction;
        $divisor = $this->gare->hab_city * $factor / 100;
        $calc = intval($basVal);
        $calc = $calc / $divisor;

        if ($calc <= 1) {
            $calc *= 100;
        }

        return intval($calc);
    }
}
