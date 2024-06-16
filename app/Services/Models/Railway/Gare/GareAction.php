<?php

namespace App\Services\Models\Railway\Gare;

use App\Models\Railway\Gare\RailwayGare;
use Carbon\Carbon;

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

        return $this->calculate(40 * $distraction);
    }

    public function calcNbSlotParking(): int
    {
        $confort = auth()->user()->railway_company->confort ?? 1;

        return $this->calculate((50 * $confort));
    }

    public function calcTimeDayWork()
    {
        $file = \Storage::get('data/horaires-des-gares.json');
        $horaire = collect(json_decode($file, true))->where('nom_normal', 'like', '%'.$this->gare->name.'%')->first();

        if (isset($horaire)) {
            $switch = explode('-', $horaire->horaires_normal ?? '08:00-20:00');

            return Carbon::createFromTimeString($switch[0])->diffInHours($switch[1] < $switch[0] ? Carbon::createFromTimeString($switch[1])->addDay() : Carbon::createFromTimeString($switch[1]));
        } else {
            return match ($this->gare->type->value) {
                'halte' => 24,
                'small' => rand(8, 12),
                'medium' => rand(12, 16),
                default => rand(16, 20)
            };
        }
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
