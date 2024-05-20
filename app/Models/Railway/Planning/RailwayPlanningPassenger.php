<?php

namespace App\Models\Railway\Planning;

use App\Enums\Railway\Users\RailwayLigneTarifTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RailwayPlanningPassenger extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'railway';
    protected $casts = [
        'type' => RailwayLigneTarifTypeEnum::class,
    ];

    public function railwayPlanning(): BelongsTo
    {
        return $this->belongsTo(RailwayPlanning::class, 'railway_planning_id');
    }
}
