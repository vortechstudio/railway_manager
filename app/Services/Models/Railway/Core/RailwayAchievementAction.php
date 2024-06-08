<?php

namespace App\Services\Models\Railway\Core;

use App\Models\Railway\Core\RailwayAchievement;
use App\Models\User\User;
use App\Notifications\SendMessageAdminNotification;
use Illuminate\Events\Dispatcher;

class RailwayAchievementAction
{
    public function __construct(private RailwayAchievement $achievement)
    {
    }

    /**
     * Register the listeners for the subscriber.
     * Ne pas oublier de rajouter un $event->listen a chaque demande achievable
     *
     * @param Dispatcher $events
     */
    public function subscribe(Dispatcher $events)
    {
        $events->listen('eloquent.saved: App\Models\User\Railway\UserRailway', [$this, 'Welcome']);
    }

    public function Welcome($event)
    {
        $user = User::find($event->user_id);
        $this->achievement->unlockActionFor($user, 'welcome');
        $this->notifyAchievementUnlock($event->user);
    }

    public function notifyAchievementUnlock(User $user)
    {
        if ($this->achievement) {
            $user->notify(new SendMessageAdminNotification(
                title: 'Nouveau succès débloquer !',
                sector: 'alert',
                type: 'success',
                message: "Un nouveau succès à été débloquer !"
            ));
        }
    }
}
