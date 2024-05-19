<?php

namespace App\Models\Railway\Config;

use Illuminate\Database\Eloquent\Model;

class RailwayBadgeReward extends Model
{
    protected $guarded = [];
    protected $connection = 'railway';

    public $timestamps = false;

    public function badge()
    {
        return $this->belongsTo(RailwayBadge::class, 'badge_id');
    }
}
