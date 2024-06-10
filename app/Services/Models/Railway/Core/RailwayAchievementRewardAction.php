<?php

namespace App\Services\Models\Railway\Core;

use App\Models\Railway\Core\RailwayAchievementReward;

class RailwayAchievementRewardAction
{
    public function __construct(private RailwayAchievementReward $reward)
    {
    }

    public function claim(): void
    {
        match ($this->reward->type->value) {
            'argent' => $this->claimArgent()
        };
    }

    private function claimArgent(): void
    {
        auth()->user()->railway->argent += $this->reward->quantity;
        auth()->user()->railway->save();
    }
}
