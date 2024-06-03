<?php

namespace App\Services\Models\User\Railway;

use App\Actions\Railway\EngineSelectAction;
use App\Models\User\Railway\UserRailwayEngine;
use App\Services\Models\Railway\Engine\RailwayEngineAction;
use Carbon\Carbon;

class UserRailwayEngineAction
{
    public function __construct(private readonly UserRailwayEngine $engine)
    {
    }

    public function getStatusFormat(?string $format = null): string
    {
        return match ($format) {
            default => $this->formatStatusDefault(),
            'icon' => $this->formatStatusIcon(),
            'color' => $this->formatStatusColor(),
        };
    }

    public function getUsedRuntimeEngine()
    {
        $totalRuntime = $this->engine->plannings()
            ->get()
            ->sum('kilometer');

        return ($totalRuntime / $this->engine->max_runtime) * 100;
    }

    public function getResultat()
    {
        $sum = 0;
        foreach ($this->engine->plannings()->where('status', 'arrival')->get() as $item) {
            $sum += $item->travel->getResultat();
        }

        return $sum;
    }

    public function getIndiceAncien(?Carbon $dateDerniereVisiteCurative = null)
    {
        if (! isset($dateDerniereVisiteCurative)) {
            $dateDerniereVisiteCurative = now();
        }

        $maxLife = max(1, Carbon::parse($this->engine->date_achat)->diffInYears(now()));
        $base = max(1, $maxLife / 4);
        $dureeEcouleeDepuisVisiteCurative = $dateDerniereVisiteCurative->diffInYears(now());
        $indice = ($dureeEcouleeDepuisVisiteCurative / $base);

        return max(0, min(5, $indice));
    }

    public function getVitesseUsure()
    {
        if ($this->engine->railwayEngine->type_train->value == 'automotrice') {
            $bogie = (new RailwayEngineAction($this->engine->railwayEngine))->getCoefEssieux() * $this->engine->railwayEngine->technical->nb_wagon;
            $motor = (new EngineSelectAction())->selectorTypeMotor($this->engine->railwayEngine->technical->motor->value, 'coef');
            $marchandise = (new EngineSelectAction())->selectorTypeMarchandise($this->engine->railwayEngine->technical->marchandise->value, 'coef');
            $typeTrain = (new EngineSelectAction())->selectorTypeTrain('automotrice', 'coef');
            $calc = ($bogie + $motor + ($marchandise * $typeTrain) / 10000) / 10;

            return round($calc, 2);
        } else {
            $bogie = (new RailwayEngineAction($this->engine->railwayEngine))->getCoefEssieux() * 2;
            $motor = (new EngineSelectAction())->selectorTypeMotor($this->engine->railwayEngine->technical->motor->value, 'coef');
            $typeTrain = (new EngineSelectAction())->selectorTypeTrain($this->engine->railwayEngine->type_train->value, 'coef');
            $calc = ($bogie + $motor * $typeTrain);

            return round($calc, 2);
        }
    }

    public function getTotalUsure()
    {
        $kilometrage = $this->engine->plannings()->where('status', 'arrival')->get()->sum('kilometer');
        $usureTotal = $this->getVitesseUsure() * ($kilometrage / 100);

        return min($usureTotal, $this->engine->max_runtime);
    }

    public function simulateSelling()
    {
        $usure = $this->getTotalUsure();
        if ($usure == 0) {
            return $this->engine->railwayEngine->price->achat / 2;
        } else {
            return ($this->engine->railwayEngine->price->achat / 2) * $usure / 100;
        }

    }

    public function verifEngine()
    {
        $calDistanceParcoure = $this->engine->plannings()
            ->where('status', 'arrival')
            ->sum('kilometer');

        return $calDistanceParcoure >= $this->engine->max_runtime && $this->engine->status == 'free';
    }

    public function getRentabilityPercent(): float|int
    {
        return (($this->getResultat() - $this->engine->railwayEngine->price->achat) / $this->engine->railwayEngine->price->achat) * 100;
    }

    public function getAmountMaintenancePrev()
    {
        return floatval($this->engine->railwayEngine->price->maintenance * \Helpers::minToHoursDecimal($this->engine->railwayEngine->duration_maintenance->diffInMinutes(now()->startOfDay())) / 4);
    }

    public function getAmountMaintenanceCur()
    {
        return floatval($this->engine->railwayEngine->price->maintenance * \Helpers::minToHoursDecimal($this->engine->railwayEngine->duration_maintenance->diffInMinutes(now()->startOfDay())));
    }

    private function formatStatusDefault()
    {
        return match ($this->engine->status->value) {
            'free' => 'Disponible',
            'in_delivery' => 'Livraison en cours',
            'in_maintenance' => 'Maintenance en cours',
            'travel' => 'Voyage en cours',
            'nofree' => 'Non disponible'
        };
    }

    private function formatStatusIcon()
    {
        return match ($this->engine->status->value) {
            'free' => 'fa-solid fa-train',
            'in_delivery' => 'fa-solid fa-truck',
            'in_maintenance' => 'fa-solid fa-gears',
            'travel' => 'fa-solid fa-route',
            'nofree' => 'fa-solid fa-ban'
        };
    }

    private function formatStatusColor()
    {
        return match ($this->engine->status->value) {
            'free' => 'green',
            'in_delivery' => 'orange',
            'in_maintenance', 'nofree' => 'gray',
            'travel' => 'purple'
        };
    }
}
