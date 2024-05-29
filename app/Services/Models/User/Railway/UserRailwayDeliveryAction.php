<?php

namespace App\Services\Models\User\Railway;

use App\Models\User\Railway\UserRailwayDelivery;

class UserRailwayDeliveryAction
{
    public function __construct(private UserRailwayDelivery $delivery)
    {
    }

    public function getIconOfType()
    {
        return match ($this->delivery->type->value) {
            'hub' => \Storage::url('icons/railway/hub.png'),
            'ligne' => \Storage::url('icons/railway/ligne.png'),
            'engine' => \Storage::url('icons/railway/train.png'),
            'research' => \Storage::url('icons/railway/research.png'),
        };
    }

    public function getDiffInSecond()
    {
        return $this->delivery->end_at->diffInSeconds($this->delivery->start_at);
    }
}
