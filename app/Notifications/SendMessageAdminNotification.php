<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Notifications\Notification;

class SendMessageAdminNotification extends Notification implements ShouldQueue
{
    use Queueable;

    public function __construct(
        public string $title,
        public string $sector,
        public string $type = 'info',
        public string $message = '',
    ) {
    }

    public function via($notifiable): array
    {
        return ['database'];
    }

    public function toDatabase($notifiable): array
    {
        return [
            'type' => $this->type,
            'icon' => $this->getIcon($this->type),
            'title' => $this->title,
            'description' => $this->message,
            'time' => now(),
            'sector' => $this->sector,
        ];
    }

    public function toArray($notifiable): array
    {
        return [];
    }

    private function getIcon($type)
    {
        return match ($type) {
            'success' => 'fas fa-check',
            'error' => 'fas fa-times',
            'warning' => 'fas fa-exclamation-triangle',
            default => 'fas fa-info-circle',
        };
    }
}
