<?php

namespace App\Actions\Railway;

use App\Models\Railway\Engine\RailwayEngine;
use App\Models\User\Railway\UserRailwayHub;

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
     * Calculate the price for maintenance.
     *
     * @param string $type_transport The type of transport.
     * @param string $type_train The type of train.
     * @param string $type_motor The type of motor.
     * @return float|int The calculated price for maintenance.
     */
    public function calcPriceMaintenance(string $type_transport, string $type_train, string $type_motor): float|int
    {
        $base_maintenance = (new EngineSelectAction())->selectorTypeTransport($type_transport, 'base_maintenance');
        $coef_train = (new EngineSelectAction())->selectorTypeTrain($type_train, 'coef');
        $coef_motor = (new EngineSelectAction())->selectorTypeMotor($type_motor, 'coef');

        return $base_maintenance * $coef_train * $coef_motor;
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

    /**
     * Generates a mission code based on the type of railway engine and user railway hub.
     *
     * @param  RailwayEngine  $engine  The railway engine object.
     * @param  UserRailwayHub  $hub  The user railway hub object.
     * @return int|string The generated mission code.
     */
    public function generateMissionCode(RailwayEngine $engine, UserRailwayHub $hub): int|string
    {
        $missionCode = 0;
        switch ($engine->type_transport->value) {
            case 'ter' || 'intercity':
                $depNum = $this->getDepartementNumberOfHub($hub);
                $missionCode = $this->generateUniqueNumber(6, [$depNum]);
                break;

            case 'tgv':
                $missionCode = $this->generateUniqueNumber(4, ['80']);
                break;

            case 'tram':
                $letters = \Str::limit(\Str::upper($hub->railwayHub->gare->name), 3, '');
                $digitPart = $this->generateUniqueNumber(5, [], true);
                $missionCode = $letters.'-'.$digitPart;
                break;

            case 'metro':
                break;

            case 'other':
                $missionCode = $this->generateUniqueNumber(rand(5, 6));
                break;
        }

        return $missionCode;
    }

    /**
     * Generates a unique number based on the given length and prefix.
     *
     * @param  int  $length  The desired length of the generated number.
     * @param  array  $prefix  An array of prefixes to be included in the number.
     * @param  bool  $excludePrefixFromLength  Determines whether to exclude the length of the prefix from the total length of the generated number.
     * @return string The generated unique number.
     */
    private function generateUniqueNumber(int $length, array $prefix = [], bool $excludePrefixFromLength = false): string
    {
        $number = '';
        foreach ($prefix as $p) {
            $number .= $p;
        }
        if ($excludePrefixFromLength) {
            $length -= strlen($number);
        }
        $existingCodes = $this->getAllExistingMissionCodes();
        do {
            while (strlen($number) < $length) {
                $number .= mt_rand(0, 9);
            }
        } while (in_array($number, $existingCodes));

        return $number;

    }

    /**
     * Retrieves all existing mission codes from the authenticated user's user railway hubs and engines.
     *
     * @return array The array of existing mission codes.
     */
    private function getAllExistingMissionCodes(): array
    {
        $ens = auth()->user()->userRailwayHub()->with('userRailwayEngine')->get();
        $data = collect();
        foreach ($ens as $en) {
            foreach ($en->userRailwayEngine as $engine) {
                $data->push([$engine->number]);
            }
        }

        return $data->toArray();
    }

    /**
     * Get the department number of a railway hub.
     *
     * @param  UserRailwayHub  $hub  The user's railway hub.
     * @return string The department number.
     */
    private function getDepartementNumberOfHub(UserRailwayHub $hub): string
    {
        $response = \Http::withoutVerifying()
            ->get('https://geo.api.gouv.fr/communes?nom='.$hub->railwayHub->gare->name.'&fields=nom,codeDepartement&format=json&geometry=centre')
            ->object();

        return $response[0]->codeDepartement;
    }
}
