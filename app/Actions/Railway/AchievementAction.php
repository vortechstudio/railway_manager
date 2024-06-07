<?php

namespace App\Actions\Railway;

use App\Models\Railway\Core\Achievement;
use App\Models\Railway\Core\AchieveReward;
use App\Models\User\User;
use App\Notifications\Users\SendMessageNotification;
use Illuminate\Support\Facades\Auth;

class AchievementAction
{
    public function __construct(public Achievement $achievement)
    {
    }

    public function subscribe($events): void
    {
        if (Auth::check()) {
            $events->listen('eloquent.created: App\Models\User\Railway\UserRailwayHub', [$this, $this->checkoutHubAction()]);
            $events->listen('App\Events\Model\User\Railway\NewUserEvent', [$this, $this->welcomeAction()]);
            $events->listen('App\Events\Model\User\UserLevelledUp', [$this, $this->level_upAction()]);
        }
    }

    private function welcomeAction()
    {
        \Auth::user()->railway_achievements()->create([
            'user_id' => auth()->id(),
            'achievement_id' => $this->achievement->id,
        ]);

        foreach ($this->achievement->rewards as $reward) {
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

    private function checkoutHubAction()
    {
        dd(auth()->user());
        if (\Auth::user()->userRailwayHub()->get()->count() == $this->achievement->goal) {
            \Auth::user()->railway_achievements()->create([
                'user_id' => auth()->id(),
                'achievement_id' => $this->achievement->id,
            ]);

            foreach ($this->achievement->rewards as $reward) {
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

    private function level_upAction()
    {
        $user = User::find(auth()->id());

        if($user->railway->level == $this->achievement->goal) {
            \Auth::user()->railway_achievements()->create([
                'achievement_id' => $this->achievement->id,
                'user_id' => $user->id
            ]);

            \Auth::user()->notify(new SendMessageNotification(
                title: 'Récompense disponible',
                sector: 'alert',
                type: 'success',
                message: 'Vous avez débloqué un nouveau succès !'
            ));
        }
    }
}
