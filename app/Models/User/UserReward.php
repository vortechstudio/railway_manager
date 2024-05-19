<?php

namespace App\Models\User;

use App\Models\Railway\Config\RailwayLevelReward;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReward extends Model
{
    public $timestamps = false;
    protected $connection = 'railway';
    protected $guarded = [];

    protected $casts = [
        'awarded_at' => 'timestamp',
    ];

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function railwayLevelReward(): BelongsTo
    {
        return $this->belongsTo(RailwayLevelReward::class, 'railway_level_reward_id');
    }
}
