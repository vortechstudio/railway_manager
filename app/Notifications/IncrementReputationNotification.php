<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;
use NotificationChannels\WebPush\WebPushChannel;
use NotificationChannels\WebPush\WebPushMessage;

class IncrementReputationNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(public int $oldReputation, public int $newReputation)
    {
    }

    public function via($notifiable): array
    {
        return [WebPushChannel::class];
    }

    public function toWebPush($notifiable, $notification)
    {
        return (new WebPushMessage())
            ->title('Votre réputation à augmenter')
            ->body($this->oldReputation.' => '.$this->newReputation);

    }
}
