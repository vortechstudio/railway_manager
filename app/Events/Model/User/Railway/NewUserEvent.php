<?php

namespace App\Events\Model\User\Railway;

use App\Models\User\User;
use Illuminate\Foundation\Events\Dispatchable;

class NewUserEvent
{
    use Dispatchable;

    public function __construct(public User $user)
    {
    }
}
