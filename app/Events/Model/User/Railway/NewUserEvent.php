<?php

namespace App\Events\Model\User\Railway;

use App\Models\User\Railway\UserRailway;
use Illuminate\Foundation\Events\Dispatchable;

class NewUserEvent
{
    use Dispatchable;

    public function __construct(public UserRailway $user)
    {
    }
}
