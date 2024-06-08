<?php

namespace App\Models\Railway\Core\Achievement;

use Illuminate\Database\Eloquent\Model;

class AchievementCondition extends Model
{
    protected $guarded = [];
    protected $connection = 'railway';
    protected $table = 'achievement_condition';
}
