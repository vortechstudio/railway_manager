<?php

namespace App\Models\Railway\Core;

use App\Enums\Railway\Core\AchievementRewardTypeEnum;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class AchieveReward extends Model
{
    use HasFactory;

    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'railway';
    protected $casts = [
        'type_reward' => AchievementRewardTypeEnum::class,
    ];
    protected $appends = [
        'icon',
    ];

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'achievements_rewards', 'reward_id', 'achievement_id');
    }

    public function getIconAttribute()
    {
        return \Storage::url('icons/railway/' . $this->type_reward->value . '.png');
    }
}
