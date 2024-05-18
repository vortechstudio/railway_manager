<?php

namespace App\Models\User;

use App\Models\Railway\Config\RailwayQuest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuests extends Model
{
    public $timestamps = false;
    protected $connection = 'railway';
    protected $guarded = [];

    protected $casts = [
        'completed_at' => 'timestamp',
    ];

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    protected function railwayQuest(): BelongsTo
    {
        return $this->belongsTo(RailwayQuest::class, 'railway_quest_id');
    }
}
