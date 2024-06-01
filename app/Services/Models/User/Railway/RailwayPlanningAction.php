<?php

namespace App\Services\Models\User\Railway;

use App\Models\Railway\Planning\RailwayPlanning;
use Carbon\Carbon;

class RailwayPlanningAction
{
    public function __construct(private RailwayPlanning $planning)
    {
    }

    public function prepareVoyageur(): void
    {
        match ($this->planning->userRailwayEngine->railwayEngine->type_transport->value) {
            'ter', 'other' => $this->prepareUniqueVoyageur(),
            'tgv', 'ic' => $this->prepareDoubleVoyageur()
        };
    }

    private function prepareUniqueVoyageur(): void
    {
        $this->planning->passengers()->create([
            'type' => 'unique',
            'nb_passengers' => rand(1, $this->planning->userRailwayLigne->tarifs()->where('type_tarif', 'unique')->whereDate('date_tarif', Carbon::today())->first()->offre),
            'railway_planning_id' => $this->planning->id,
        ]);
    }

    private function prepareDoubleVoyageur(): void
    {
        $this->planning->passengers()->create([
            'type' => 'first',
            'nb_passengers' => rand(1, $this->planning->userRailwayLigne->tarifs()->where('type_tarif', 'first')->whereDate('date_tarif', Carbon::today())->first()->offre),
            'railway_planning_id' => $this->planning->id,
        ]);

        $this->planning->passengers()->create([
            'type' => 'second',
            'nb_passengers' => rand(1, $this->planning->userRailwayLigne->tarifs()->where('type_tarif', 'second')->whereDate('date_tarif', Carbon::today())->first()->offre),
            'railway_planning_id' => $this->planning->id,
        ]);
    }
}
