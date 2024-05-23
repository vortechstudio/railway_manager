<?php

namespace App\Models\User\Railway;

use App\Models\Railway\Core\Achievement;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayAchievement extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    public function achievement(): BelongsTo
    {
        return $this->belongsTo(Achievement::class, 'achievement_id');
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
