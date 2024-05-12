<?php

namespace App\Livewire\Account;

use App\Models\User\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ProfilCardUser extends Component
{
    use LivewireAlert;

    public User $user;
    public string $name = '';

    public function mount()
    {
        $this->name = $this->user->name;
    }

    public function resetForm()
    {
        $this->name = $this->user->name;
    }

    public function saveName()
    {
        try {
            $this->user->update([
                'name' => $this->name
            ]);
            $this->user->logs()->create([
                'action' => "Changement du nom dans railway Manager",
                "user_id" => $this->user->id
            ]);

            $this->alert('success', "Changement de Nom Effectuer");
            $this->dispatch('closeModal', 'editName');
            $this->dispatch('refreshComponent');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', "Erreur lors du changment du nom dans railway Manager");
        }
    }

    #[On('refreshComponent')]
    public function refreshComponent()
    {
        $this->dispatch('$refresh');
    }

    public function render()
    {
        return view('livewire.account.profil-card-user');
    }
}
