<?php

namespace App\Models\Railway\Core\Achievement;

use Illuminate\Database\Eloquent\Model;

class AchievementReward extends Model
{
    protected $guarded = [];
    protected $connection = 'railway';
    protected $table = 'achievement_reward';
}
