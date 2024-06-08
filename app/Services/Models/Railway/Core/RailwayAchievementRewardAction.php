<?php

namespace App\Services\Models\Railway\Core;

use App\Models\Railway\Core\RailwayAchievementReward;

class RailwayAchievementRewardAction
{
    public function __construct(private RailwayAchievementReward $reward)
    {
    }

    public function claim()
    {
        match ($this->reward->type->value) {
            "argent" => $this->claimArgent()
        };
    }

    private function claimArgent()
    {
        auth()->user()->railway->argent += $this->reward->quantity;
        auth()->user()->railway->save();
    }
}
