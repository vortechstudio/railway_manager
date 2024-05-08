<?php

namespace App\Models\Railway\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RailwayLevel extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    public function reward(): BelongsTo
    {
        return $this->belongsTo(RailwayLevelReward::class, 'railway_level_reward_id', 'id');
    }
}
