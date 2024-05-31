<?php

namespace App\Jobs;

use App\Models\User\Railway\UserRailwayDelivery;
use App\Services\Models\User\Railway\UserRailwayAction;
use App\Services\Models\User\Railway\UserRailwayDeliveryAction;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeliveryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public UserRailwayDelivery $delivery)
    {
    }

    public function handle(): void
    {
        if($this->delivery->exists()) {
            (new UserRailwayDeliveryAction($this->delivery))->delivered();;
        } else {
            $this->delete();
        }

        match ($this->delivery->type->value) {
            'hub' => (new UserRailwayAction($this->delivery->user->railway))->addExperience(200),
            'ligne' => (new UserRailwayAction($this->delivery->user->railway))->addExperience(35),
            'engine' => (new UserRailwayAction($this->delivery->user->railway))->addExperience(30),
            'research' => (new UserRailwayAction($this->delivery->user->railway))->addExperience(50),
        };

        $this->delivery->user->railway->addReputation($this->delivery->type->value, null);

    }
}
