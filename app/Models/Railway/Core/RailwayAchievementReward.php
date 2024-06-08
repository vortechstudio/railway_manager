<?php

namespace App\Models\Railway\Core;

use App\Enums\Railway\Core\AchievementRewardTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class RailwayAchievementReward extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'type' => AchievementRewardTypeEnum::class,
    ];

    protected $appends = [
        'icons',
    ];

    public function railwayAchievement(): BelongsTo
    {
        return $this->belongsTo(RailwayAchievement::class);
    }

    public function getIconAttribute()
    {
        return \Storage::url('icons/railway/'.$this->type->value.'.png');
    }
}
