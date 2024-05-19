<?php

namespace App\Actions\Railway;

use AnthonyMartin\GeoLocation\GeoPoint;

class LigneStationAction
{
    /**
     * Calculates the distance between two geographical points.
     *
     * @param  float  $lat1  The latitude of the first point.
     * @param  float  $lon1  The longitude of the first point.
     * @param  float  $lat2  The latitude of the second point.
     * @param  float  $lon2  The longitude of the second point.
     * @return float|int The distance between the two points in kilometers.
     */
    public function calculDistance(float $lat1, float $lon1, float $lat2, float $lon2): float|int
    {
        $geoA = new GeoPoint($lat1, $lon1);
        $geoB = new GeoPoint($lat2, $lon2);

        return $geoA->distanceTo($geoB, 'km');
    }

    /**
     * Returns the speed limit based on the given type of transportation.
     *
     * @param  string  $type  The type of transportation.
     * @return int The speed limit.
     */
    public function vitesseByType(string $type): int
    {
        return match ($type) {
            'ter', 'intercity' => 160,
            'tgv' => 320,
            'tram' => 80,
            'transilien' => 120,
            'metro' => 60,
            'other' => 90
        };
    }

    /**
     * Converts the given vitesse (speed) from kilometers per hour to meters per second.
     *
     * @param  int  $vitesse  The speed in kilometers per hour.
     * @return float The speed converted to meters per second.
     */
    public function convertVitesse(int $vitesse): float
    {
        return $vitesse / 3.6;
    }

    /**
     * Calculates the time taken to travel a given distance at a certain speed.
     *
     * @param  float|int  $distance  The distance to be covered.
     * @param  float|int  $vitesse  The speed at which the distance is covered.
     * @return int The time taken to cover the distance in minutes.
     */
    public function calculTemps(float|int $distance, float|int $vitesse): int
    {
        $timeInSecond = $distance / $vitesse;

        return intval(($timeInSecond * 60) / 1.8);
    }
}
