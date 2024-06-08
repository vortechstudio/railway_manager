<?php

namespace App\Models\Railway\Core\Achievement;

use Illuminate\Database\Eloquent\Model;

class Condition extends Model
{
    protected $guarded = [];
    protected $connection = 'railway';

    public function achievements()
    {
        return $this->belongsToMany(Achievement::class, 'achievement_condition')
            ->withTimestamps();
    }
}
