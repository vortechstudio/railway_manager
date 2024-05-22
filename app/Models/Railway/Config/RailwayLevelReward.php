<?php

namespace App\Models\Railway\Config;

use App\Enums\Railway\Config\LevelRewardTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class RailwayLevelReward extends Model
{
    public $timestamps = false;

    protected $connection = 'railway';

    protected $guarded = [];

    protected $casts = [
        'type' => LevelRewardTypeEnum::class,
    ];

    public function levels(): HasMany
    {
        return $this->hasMany(RailwayLevel::class);
    }
}
