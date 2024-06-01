<?php

namespace App\Services\Models\User\Railway;

use App\Models\Railway\Config\RailwayLevel;
use App\Models\User\Railway\UserRailway;
use App\Services\Models\Railway\Core\RailwayLevelRewardAction;

class UserRailwayAction
{
    public function __construct(private UserRailway $userRailway)
    {
    }

    public function addExperience(int $experienceAdd)
    {
        $this->userRailway->xp += $experienceAdd;
        $this->userRailway->save();

        $nextLevelXp = $this->userRailway->next_level_xp;
        if ($this->userRailway->xp >= $nextLevelXp) {
            $this->userRailway->level++;
            $this->userRailway->save();

            $level = RailwayLevel::find($this->userRailway->level);
            $reward = $level->reward;
            (new RailwayLevelRewardAction($reward))->rewarding();
        }
    }
}
