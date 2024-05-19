<?php

namespace App\Actions\Railway;

use App\Models\Railway\Core\Achievement;
use App\Models\Railway\Core\AchieveReward;

class AchievementAction
{
    public function handle(Achievement $achievement)
    {
        return match ($achievement->action) {
            'welcome' => $this->welcomeAction($achievement),
        };
    }

    private function welcomeAction(Achievement $achievement)
    {
        \Auth::user()->railway_achievements()->create([
            'user_id' => auth()->id(),
            'achievement_id' => $achievement->id,
        ]);

        foreach ($achievement->rewards as $reward) {
            \Auth::user()->railway_rewards()->create([
                'user_id' => auth()->id(),
                'model' => AchieveReward::class,
                'model_id' => $reward->id,
            ]);
            (new AchievementRewardAction())->handle($reward, \Auth::user());

            toastr()
                ->addSuccess('Vous avez débloquer un nouveau succès !');
        }

        return true;

    }
}
