<?php

namespace App\Livewire\Account;

use App\Models\User\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ProfilTab extends Component
{
    use LivewireAlert;

    public User $user;

    public function render()
    {
        return view('livewire.account.profil-tab');
    }
}
