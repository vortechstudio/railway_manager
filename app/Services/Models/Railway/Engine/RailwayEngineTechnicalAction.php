<?php

namespace App\Services\Models\Railway\Engine;

class RailwayEngineTechnicalAction
{
    public function __construct(private \App\Models\Railway\Engine\RailwayEngineTechnical $technical)
    {
    }

    public function calcDurationMaintenancePrev(): \Illuminate\Support\Carbon
    {
        $durationMaintMin = $this->technical->engine->duration_maintenance->diffInMinutes(now()->startOfDay());
        $diff = $durationMaintMin * 40 / 100;

        return now()->startOfDay()->addMinutes($diff);
    }
}
