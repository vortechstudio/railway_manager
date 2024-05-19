<?php

namespace App\Actions\Railway;

class EngineAction extends EngineSelectAction
{
    /**
     * Calculate the purchase price of a train
     *
     * @param  string  $type_train  The type of train (motrice, voiture, automotrice, bus)
     * @param  string  $type_energy  The type of energy (vapeur, diesel, electrique, hybride, none)
     * @param  string  $type_motor  The type of motor
     * @param  string  $type_marchandise  The type of merchandise
     * @param  float|int  $valEssieux  The value of essieux
     * @param  int  $nbWagon  The number of wagons (default: 1)
     * @return float|int The calculated purchase price
     */
    public function calcTarifAchat(string $type_train, string $type_energy, string $type_motor, string $type_marchandise, float|int $valEssieux, int $nbWagon = 1): float|int
    {
        $train = match ($type_train) {
            'motrice' => 10000,
            'voiture' => 2500,
            'automotrice' => 20000,
            'bus' => 1000
        };

        $energy = match ($type_energy) {
            'vapeur' => 500,
            'diesel' => 1300,
            'electrique' => 3500,
            'hybride' => 4300,
            'none' => 0
        };

        if ($type_train == 'automotrice') {
            $wagon = 2500 * $nbWagon;
        } else {
            $wagon = 0;
        }

        $calc = ($train + $energy + $wagon + $valEssieux) *
            self::selectorTypeTrain($type_train, 'coef') *
            self::selectorTypeEnergy($type_energy, 'coef') *
            self::selectorTypeMotor($type_motor, 'coef') *
            self::selectorTypeMarchandise($type_marchandise, 'coef');

        return $calc;
    }

    /**
     * Calculates the price of maintenance based on the duration and the value of essieux.
     *
     * @param  int  $duration  The duration of maintenance in months.
     * @param  float|int  $val_essieux  The value of essieux.
     * @return float|int The calculated price of maintenance.
     */
    public function calcPriceMaintenance(int $duration, float|int $val_essieux): float|int
    {
        $calc = $duration * $val_essieux;
        if ($calc >= 100) {
            return $calc / 10;
        }

        return $calc;
    }

    /**
     * Calculates the price of location based on the purchase price.
     *
     * @param  float|int  $price_achat  The purchase price.
     * @return float The calculated price of location.
     */
    public function calcPriceLocation(float|int $price_achat): float
    {
        return $price_achat / 30 / 1.2;
    }

    /**
     * Calculates the duration of maintenance based on the essieux, automotrice flag, and number of wagons.
     *
     * @param  string  $essieux  The essieux value.
     * @param  bool  $automotrice  Flag to indicate if it is an automotrice.
     * @param  int  $nbWagon  The number of wagons.
     * @return \Illuminate\Support\Carbon The calculated duration of maintenance.
     */
    public function calcDurationMaintenance(string $essieux, bool $automotrice = false, int $nbWagon = 1): \Illuminate\Support\Carbon
    {
        $min_init = 15;
        $calcEssieux = $min_init + self::getDataCalcForEssieux($essieux, $automotrice, $nbWagon);

        return now()->startOfDay()->addMinutes($calcEssieux);
    }

    /**
     * Calculates the data for essieux.
     *
     * @param  string  $essieux  The essieux value.
     * @param  bool  $automotrice  Flag indicating if it is automotrice.
     * @param  int  $nbWagon  The number of wagons.
     * @return float|int The calculated data.
     */
    public function getDataCalcForEssieux(string $essieux, bool $automotrice = false, int $nbWagon = 1): float|int
    {
        $bogeys = \Str::ucsplit(\Str::upper($essieux));
        $calc = 2;

        foreach ($bogeys as $bogey) {
            $calc *= match ($bogey) {
                'C' => 3,
                'D' => 4,
                'E' => 5,
                'F' => 6,
                'G' => 7,
                'H' => 8,
                'I' => 9,
                'J' => 10,
                'K' => 11,
                'L' => 12,
                'M' => 13,
                'N' => 14,
                'O' => 15,
                'P' => 16,
                'Q' => 17,
                'R' => 18,
                'S' => 19,
                'T' => 20,
                'U' => 21,
                'V' => 22,
                'W' => 23,
                'X' => 24,
                'Y' => 25,
                'Z' => 26,
                default => 2
            };
        }

        if ($automotrice) {
            return $calc * $nbWagon;
        } else {
            return $calc;
        }
    }
}
