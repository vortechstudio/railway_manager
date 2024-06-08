<?php

namespace App\Models\User\Railway;

use App\Models\Railway\Core\RailwayAchievement;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayAchievement extends Model
{
    protected $guarded = [];
    protected $connection = 'railway';
    protected $casts = [
        'completed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function railwayAchievement(): BelongsTo
    {
        return $this->belongsTo(RailwayAchievement::class);
    }
}
