<?php

namespace App\Models\Railway\Core\Achievement;

use App\Enums\Railway\Core\AchievementTypeEnum;
use Illuminate\Database\Eloquent\Model;

class Achievement extends Model
{
    protected $guarded = [];
    protected $connection = 'railway';
    protected $casts = [
        'type' => AchievementTypeEnum::class,
    ];

    public function conditions()
    {
        return $this->belongsToMany(Condition::class, 'achievement_condition')
            ->withTimestamps();
    }

    public function rewards()
    {
        return $this->belongsToMany(Reward::class, 'achievement_reward')
            ->withTimestamps();
    }
}
