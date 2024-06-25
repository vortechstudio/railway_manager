<?php

namespace App\Actions\Railway;

class GareAction
{
    public function getFrequence(string $type_gare)
    {
        return match ($type_gare) {
            'halte' => rand(3500,150000),
            'small' => rand(20000, 350000),
            'medium' => rand(80000, 650000),
            'large', 'terminus' => rand(100000,3500000),
        };
    }
    /**
     * Returns the number of habitants based on the type of gare and frequency
     *
     * @param  string  $type_gare  The type of gare (halte, small, medium, large, terminus)
     * @param  int  $freq  The frequency
     * @return int The number of habitants
     */
    public function getHabitant(string $type_gare, int $freq): int
    {
        return match ($type_gare) {
            'halte' => intval($freq * 1.2),
            'small' => intval($freq * 1.8),
            'medium' => intval($freq * 2.6),
            'large' => intval($freq * 4.5),
            'terminus' => intval($freq * 5.6),
        };
    }

    /**
     * Defines the equipment available based on the type of gare
     *
     * @param  string  $type_gare  The type of gare (halte, small, medium, large, terminus)
     * @return array The array of equipment available
     */
    public function defineEquipements(string $type_gare): array
    {
        return match ($type_gare) {
            'halte' => ['info_visuel'],
            'small' => ['info_visuel', 'toilette', 'info_sonore'],
            'medium' => ['info_visuel', 'toilette', 'info_sonore', 'guichets'],
            'large', 'terminus' => ['toilette', 'info_visuel', 'info_sonore', 'guichets', 'ascenceurs', 'escalator', 'boutique', 'restaurant'],
        };
    }

    /**
     * Calculate the price based on the type of station and the number of platforms.
     *
     * @param  string  $type_gare  The type of station ('halte', 'small', 'medium', 'large', 'terminus').
     * @param  int  $nb_quai  The number of platforms.
     * @return float The calculated price.
     */
    public function definePrice(string $type_gare, int $nb_quai): float
    {
        $coef = match ($type_gare) {
            'halte' => 1.05,
            'small' => 1.20,
            'medium' => 1.80,
            'large' => 2.30,
            'terminus' => 3,
        };

        $price_base = match ($type_gare) {
            'halte' => 25000,
            'small' => 47000,
            'medium' => 78000,
            'large' => 195000,
            'terminus' => 270000,
        };

        $calc = ($price_base * $coef) * $nb_quai;

        return round($calc, 2);
    }

    /**
     * Define the taxe hub for a given price and number of quai.
     *
     * @param  float  $price  The price to calculate the taxe hub for.
     * @param  int  $nb_quai  The number of quai to calculate the taxe hub for.
     * @return float The taxe hub value.
     */
    public static function defineTaxeHub(float $price, int $nb_quai): float
    {
        $calc = $price / $nb_quai / 20 / 10;

        return round($calc, 2);
    }
}
