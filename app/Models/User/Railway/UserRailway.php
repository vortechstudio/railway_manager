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

    /**
     * Retrieves the XP percentage attribute for the model.
     *
     * @return int
     *
     * @throws \Exception
     */
    public function getXpPercentAttribute()
    {
        if($this->xp == 0) {
            return 0;
        }

        $next_level = RailwayLevel::find($this->level + 1);

        if($next_level == null) {
            throw new \Exception("Unknown level or not deployed");
        }

        $exp_next_level = $next_level->exp_required;

        if ($exp_next_level == 0) {
            return 0;
        }

        return $this->calculateXpPercent($exp_next_level);
    }

    /**
     * Calculates the percentage of experience gained towards the next level.
     *
     * @param int $exp_next_level The experience points required for the next level.
     *
     * @return float The percentage of experience gained towards the next level.
     */
    private function calculateXpPercent(int $exp_next_level): float
    {
        $percent_gained = ($this->xp / $exp_next_level) * 100;
        return 100 - $percent_gained;
    }
}
