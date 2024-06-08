<?php

namespace App\Models\Railway\Core\Achievement;

use Illuminate\Database\Eloquent\Model;

class Reward extends Model
{
    protected $guarded = [];
    protected $connection = 'railway';

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'achievement_reward')
            ->withTimestamps();
    }
}
