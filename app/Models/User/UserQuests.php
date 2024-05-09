<?php

namespace App\Models\User;

use App\Models\Railway\Config\RailwayQuest;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserQuests extends Model
{
    public $timestamps = false;

    protected $guarded = [];

    protected $casts = [
        'completed_at' => 'timestamp',
    ];

    protected function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    protected function railwayQuest(): BelongsTo
    {
        return $this->belongsTo(RailwayQuest::class);
    }
}
