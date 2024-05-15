<?php

namespace App\Livewire\Core;

use Livewire\Component;

class UserBar extends Component
{
    public function render()
    {
        //dd(auth()->user()->railway_messages()->where('is_read', false)->get()->count());
        return view('livewire.core.user-bar', [
            'countMessage' => auth()->user()->railway_messages()->where('is_read', false)->get()->count(),
        ]);
    }
}
