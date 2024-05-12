<?php

namespace App\Models\User\Railway;

use App\Models\Railway\Config\RailwayLevel;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailway extends Model
{
    public $timestamps = false;
    protected $guarded = [];

    protected $appends = [
        'xp_percent'
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getXpPercentAttribute()
    {
        $exp_next_level = RailwayLevel::find($this->level + 1)->exp_required;
        $percent_gained = ($this->xp / $exp_next_level) * 100;
        $percent_remaining = 100 - $percent_gained; //  Calcul du pourcentage restant

        return $percent_remaining;
    }
}
