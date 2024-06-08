<?php

namespace App\Services\Models\Railway\Core;

use App\Models\Railway\Core\RailwayAchievement;
use App\Models\User\Railway\UserRailwayCompany;
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
        $events->listen('eloquent.saved: App\Models\User\Railway\UserRailwayHub', [$this, 'unDebutATous']);
        $events->listen('eloquent.saved: App\Models\User\Railway\UserRailwayMouvement', [$this, 'entrepreneur']);
        $events->listen('eloquent.saved: App\Models\User\Railway\UserRailwayMouvement', [$this, 'jeRentabiliseMaSociete']);
        $events->listen('eloquent.saved: App\Models\User\Railway\UserRailwayMouvement', [$this, 'magnatFerroviaire']);
    }

    public function Welcome($event)
    {
        $user = User::find($event->user_id);
        $this->achievement->unlockActionFor($user, 'welcome');
        $this->notifyAchievementUnlock($user);
    }

    public function unDebutATous($event)
    {
        $user = User::find($event->user_id);
        $this->achievement->unlockActionFor($user, 'un-debut-a-tous', 1);
        $this->notifyAchievementUnlock($user);
    }

    public function entrepreneur($event)
    {
        $compagnie = UserRailwayCompany::find($event->user_railway_company_id);
        $user = $compagnie->user;
        $amount = $compagnie->mouvements()->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->where('type_amount', 'revenue')->sum('amount');

        if($amount >= $this->achievement->goal) {
            $this->achievement->unlockActionFor($user, 'entrepreneur', 1500000);
            $this->notifyAchievementUnlock($user);
        }
    }

    public function jeRentabiliseMaSociete($event)
    {
        $compagnie = UserRailwayCompany::find($event->user_railway_company_id);
        $user = $compagnie->user;
        $amount = $compagnie->mouvements()->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->where('type_amount', 'revenue')->sum('amount');

        if($amount >= $this->achievement->goal) {
            $this->achievement->unlockActionFor($user, 'je-rentabilise-ma-societe', 3000000);
            $this->notifyAchievementUnlock($user);
        }
    }
    public function magnatFerroviaire($event)
    {
        $compagnie = UserRailwayCompany::find($event->user_railway_company_id);
        $user = $compagnie->user;
        $amount = $compagnie->mouvements()->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->where('type_amount', 'revenue')->sum('amount');

        if($amount >= $this->achievement->goal) {
            $this->achievement->unlockActionFor($user, 'magnat-ferroviaire', 10000000);
            $this->notifyAchievementUnlock($user);
        }
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
