<?php

namespace App\Actions\Railway;

use App\Models\Railway\Core\AchieveReward;
use App\Models\User\User;

class AchievementRewardAction
{
    public function handle(AchieveReward $reward, User $user)
    {
        return match ($reward->type_reward) {
            "argent" => $this->argentAction($reward, $user),
        };
    }
}
