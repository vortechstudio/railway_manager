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
    public ?string $name = '';
    public ?string $signature = '';

    public function mount()
    {
        $this->name = $this->user->name;
        $this->signature = $this->user->profil->signature;
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

    public function saveSign()
    {
        try {
            $this->user->profil()->update([
                'signature' => $this->signature
            ]);

            $this->user->logs()->create([
                'action' => "Changement de la signature de profil",
                "user_id" => $this->user->id
            ]);

            $this->alert('success', "Changement de signature Effectuer");
            $this->dispatch('closeModal', 'editSign');
            $this->dispatch('refreshComponent');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', "Erreur lors du changement de signature.");
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
