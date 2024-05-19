<?php

namespace App\Actions\Railway;

class AdvantageDropRate
{
    /**
     * Calculates the rate of argent based on quantity.
     *
     * @param  int  $qte  The quantity of argent.
     * @return float The rate of argent.
     */
    public function rateArgent(int $qte): float
    {
        $base_rate = 90.0;
        $PerQte = 0.05;
        $rate = $base_rate - (floor($qte / 5000) * $PerQte);

        return max($rate, 10.0);
    }

    /**
     * Calculates the research rate based on the given quantity.
     *
     * @param  float  $qte  The quantity for which to calculate the research rate.
     * @return float The calculated research rate.
     */
    public function rateResearchRate(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 0.20;
        $rate = $base_rate - (floor($qte * 10) * ($PerQte * 10));

        return max($rate, 10.0);
    }

    /**
     * Calculates the research coast based on the given quantity.
     *
     * @param  float  $qte  The quantity for which to calculate the research coast.
     * @return float The calculated research coast.
     */
    public function rateResearchCoast(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 0.05;
        $rate = $base_rate - (floor($qte / 5000) * $PerQte);

        return max($rate, 10.0);
    }

    /**
     * Calculates the audit rate based on the given quantity.
     *
     * @param  float  $qte  The quantity for which to calculate the audit rate.
     * @return float The calculated audit rate.
     */
    public function rateAuditInt(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 5.0;
        $rate = $base_rate - (floor($qte / 5) * $PerQte);

        return max($rate, 10.0);
    }

    /**
     * Calculates the rate for an audit extension based on the quantity.
     *
     * @param  float  $qte  The quantity for the audit extension.
     * @return float The calculated rate for the audit extension.
     */
    public function rateAuditExt(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 5.0;
        $rate = $base_rate - (floor($qte / 5) * $PerQte);

        return max($rate, 10.0);
    }

    /**
     * Calculates the rate for a simulation based on the quantity.
     *
     * @param  float  $qte  The quantity for the simulation.
     * @return float The calculated rate for the simulation.
     */
    public function rateSimulation(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 5.0;
        $rate = $base_rate - (floor($qte / 5) * $PerQte);

        return max($rate, 10.0);
    }

    /**
     * Calculates the rate for a tax credit based on the quantity.
     *
     * @param  float  $qte  The quantity for the tax credit.
     * @return float The calculated rate for the tax credit.
     */
    public function rateCreditImpot(float $qte)
    {
        $base_rate = 90.0;
        $PerQte = 0.05;
        $rate = $base_rate - (floor($qte / 5000) * $PerQte);

        return max($rate, 10.0);
    }
}
