<?php

namespace App\Services\Models\Railway\Engine;

use App\Actions\Railway\EngineAction;
use App\Models\Railway\Engine\RailwayEngine;

class RailwayEngineAction
{
    public function __construct(private RailwayEngine $engine)
    {
    }

    public function getMasseOfEngine(): float|int
    {
        $median_loco = match ($this->engine->type_energy->value) {
            'diesel' => 100,
            'electrique' => 85,
            'hybrid' => 100,
            'vapeur' => 112,
            'none' => 0
        };

        $median_voiture = 30;

        if ($this->engine->type_train->value == 'automotrice') {
            return $median_loco + ($median_voiture * ($this->engine->technical->nb_wagon - 2)) + $median_loco;
        } else {
            if ($this->engine->type_train->value == 'motrice') {
                return $median_loco;
            } elseif ($this->engine->type_train->value == 'bus') {
                return 40;
            } else {
                return $median_voiture;
            }
        }

    }

    public function getCoefEssieux(): float
    {
        if ($this->engine->type_train->value == 'automotrice') {
            $dataEssieux = (new EngineAction())->getDataCalcForEssieux($this->engine->technical->essieux, $this->engine->type_train->value, $this->engine->technical->nb_wagon);
            if ($dataEssieux > 1000) {
                $dataEssieux /= 100;
            } elseif ($dataEssieux >= 100) {
                $dataEssieux /= 10;
            }
        } else {
            $dataEssieux = (new EngineAction())->getDataCalcForEssieux($this->engine->technical->essieux, $this->engine->type_train->value, $this->engine->technical->nb_wagon);
        }

        if ($dataEssieux > 0 && $dataEssieux <= 25) {
            return 1.2;
        } elseif ($dataEssieux > 25 && $dataEssieux <= 50) {
            return 1.8;
        } elseif ($dataEssieux > 50 && $dataEssieux <= 75) {
            return 2.2;
        } else {
            return 2.8;
        }
    }

    public function maxRuntime()
    {
        $coefTypeEngine = (new EngineAction())->selectorTypeTrain($this->engine->type_train->value, 'coef');
        $coefTypeEnergy = (new EngineAction())->selectorTypeEnergy($this->engine->type_energy->value, 'coef');
        $coefTypeMotor = (new EngineAction())->selectorTypeMotor($this->engine->technical->motor->value, 'coef');
        $coefEssieux = $this->getCoefEssieux();
        $mass = $this->getMasseOfEngine();

        if ($this->engine->type_train->value == 'automotrice') {
            return intval(($mass * $this->engine->technical->velocity * $this->engine->technical->nb_wagon) / ($coefEssieux * $coefTypeEngine * $coefTypeEnergy * $coefTypeMotor) / 4);
        } else {
            return intval(($mass * $this->engine->technical->velocity) / ($coefEssieux * $coefTypeEngine * $coefTypeEnergy * $coefTypeMotor) / 4);
        }
    }

    public function getComposition(string $type_tarif)
    {
        return match ($this->engine->type_transport->value) {
            'ter', 'other' => $this->engine->technical->nb_marchandise,
            'tgv', 'ic' => match ($type_tarif) {
                'first' => intval($this->engine->technical->nb_marchandise - ($this->engine->technical->nb_marchandise * 20 / 100)),
                'second' => intval($this->engine->technical->nb_marchandise - ($this->engine->technical->nb_marchandise * 80 / 100)),
            }
        };
    }
}
