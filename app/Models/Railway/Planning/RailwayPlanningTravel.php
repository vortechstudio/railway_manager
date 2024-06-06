<?php

namespace App\Models\Railway\Planning;

use App\Services\Models\User\Railway\RailwayPlanningTravelAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

/**
 * @mixin IdeHelperRailwayPlanningTravel
 */
class RailwayPlanningTravel extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'railway';

    public function railwayPlanning(): BelongsTo
    {
        return $this->belongsTo(RailwayPlanning::class, 'railway_planning_id');
    }

    public function getCA()
    {
        return (new RailwayPlanningTravelAction($this))->getCA();
    }

    public function getCoast()
    {
        return (new RailwayPlanningTravelAction($this))->getCoast();
    }

    public function getResultat()
    {
        return (new RailwayPlanningTravelAction($this))->getResultat();
    }
}
