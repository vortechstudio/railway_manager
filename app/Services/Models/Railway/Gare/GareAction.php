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
        return $this->calculate(50 * auth()->user()->railway_company->confort);
    }

    public function calcNbSlotPublicite(): int
    {
        return $this->calculate(25 * auth()->user()->railway_company->distraction);
    }

    public function calcNbSlotParking(): int
    {
        return $this->calculate(10 * auth()->user()->railway_company->confort);
    }

    private function calculate(int $factor): int
    {
        $basVal = $this->gare->freq_base * auth()->user()->railway_company->distraction;
        $divisor = $this->gare->hab_city * $factor / 100;
        $calc = intval($basVal);
        $calc = $calc / $divisor;

        if ($calc <= 1) {
            $calc *= 100;
        }

        return intval($calc);
    }
}
