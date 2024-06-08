<?php

namespace App\Listeners\Model\User;

use App\Events\Model\User\UserLevelledUp;
use App\Notifications\SendMessageAdminNotification;

class UserLevelledUpListener
{
    public function __invoke(UserLevelledUp $event): void
    {
        $event->user->notify(new SendMessageAdminNotification(
            title: 'Level UP',
            sector: 'alert',
            type: 'info',
            message: 'Des récompenses de niveau sont disponible !'
        ));
    }
}
