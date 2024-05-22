<?php

namespace App\Models\Railway\Planning;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RailwayPlannningLog extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    public function railwayPlanning(): BelongsTo
    {
        return $this->belongsTo(RailwayPlanning::class, 'railway_planning_id');
    }
}
