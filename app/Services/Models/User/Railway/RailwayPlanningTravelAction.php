<?php

namespace App\Services\Models\User\Railway;

use App\Models\Railway\Planning\RailwayPlanningTravel;

class RailwayPlanningTravelAction
{
    public function __construct(private RailwayPlanningTravel $planningTravel)
    {
    }

    public function getCA()
    {
        return $this->planningTravel->ca_billetterie + $this->planningTravel->ca_other;
    }

    public function getCoast()
    {
        return $this->planningTravel->fee_electrique + $this->planningTravel->fee_gasoil + $this->planningTravel->fee_other;
    }

    public function getResultat()
    {
        return $this->getCA() - $this->getCoast();
    }
}
