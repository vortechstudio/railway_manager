<?php

namespace App\Services\Models\Railway\Core;

use App\Events\Model\User\Railway\NewUserEvent;
use App\Models\Railway\Core\RailwayAchievement;
use App\Models\User\Railway\UserRailwayCompany;
use App\Models\User\User;
use Illuminate\Events\Dispatcher;

class RailwayAchievementAction
{
    public function __construct(private RailwayAchievement $achievement)
    {
    }

    /**
     * Register the listeners for the subscriber.
     * Ne pas oublier de rajouter un $event->listen a chaque demande achievable
     */
    public function subscribe(Dispatcher $events): void
    {
        $events->listen(NewUserEvent::class, [$this, 'Welcome']);
        $events->listen('eloquent.created: App\Models\User\Railway\UserRailwayHub', [$this, 'unDebutATous']);
        $events->listen('eloquent.created: App\Models\User\Railway\UserRailwayMouvement', [$this, 'entrepreneur']);
        $events->listen('eloquent.created: App\Models\User\Railway\UserRailwayMouvement', [$this, 'jeRentabiliseMaSociete']);
        $events->listen('eloquent.created: App\Models\User\Railway\UserRailwayMouvement', [$this, 'magnatFerroviaire']);
    }

    public function Welcome($event): void
    {
        $user = User::find($event->user->id);
        $this->achievement->unlockActionFor($user, 'welcome');
    }

    public function unDebutATous($event): void
    {
        $user = User::find($event->user_id);
        if ($user->userRailwayHub()->count() == 1) {
            $this->achievement->unlockActionFor($user, 'un-debut-a-tous', 1);
        }
    }

    public function entrepreneur($event): void
    {
        $compagnie = UserRailwayCompany::find($event->user_railway_company_id);
        $user = $compagnie->user;
        $amount = $compagnie->mouvements()->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->where('type_amount', 'revenue')->sum('amount');

        if ($amount >= $this->achievement->goal) {
            $this->achievement->unlockActionFor($user, 'entrepreneur', 1500000);
        }
    }

    public function jeRentabiliseMaSociete($event): void
    {
        $compagnie = UserRailwayCompany::find($event->user_railway_company_id);
        $user = $compagnie->user;
        $amount = $compagnie->mouvements()->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->where('type_amount', 'revenue')->sum('amount');

        if ($amount >= $this->achievement->goal) {
            $this->achievement->unlockActionFor($user, 'je-rentabilise-ma-societe', 3000000);
        }
    }

    public function magnatFerroviaire($event): void
    {
        $compagnie = UserRailwayCompany::find($event->user_railway_company_id);
        $user = $compagnie->user;
        $amount = $compagnie->mouvements()->whereBetween('created_at', [now()->startOfDay(), now()->endOfDay()])->where('type_amount', 'revenue')->sum('amount');

        if ($amount >= $this->achievement->goal) {
            $this->achievement->unlockActionFor($user, 'magnat-ferroviaire', 10000000);
        }
    }
}
