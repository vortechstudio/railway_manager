<?php

namespace App\Livewire\Core;

use App\Models\User\User;
use Livewire\Component;

class UserNotification extends Component
{
    public function markAsRead($id): void
    {
        try {
            User::find(auth()->user()->id)->notifications()->find($id)
                ->markAsRead();
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
        }
    }

    public function render()
    {
        return view('livewire.core.user-notification');
    }
}
