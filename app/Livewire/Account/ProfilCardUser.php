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
    public bool $accept_friends = false;
    public bool $display_registry = false;
    public bool $display_online_status = false;
    public bool $btnIsDisabled = false;
    public string $code = '';

    public function mount()
    {
        $this->name = $this->user->name;
        $this->signature = $this->user->profil->signature;
        $this->accept_friends = $this->user->railway_social->accept_friends;
        $this->display_registry = $this->user->railway_social->display_registry;
        $this->display_online_status = $this->user->railway_social->display_online_status;
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

    public function saveSocial()
    {
        try {
            $this->user->railway_social->accept_friends = $this->accept_friends;
            $this->user->railway_social->display_registry = $this->display_registry;
            $this->user->railway_social->display_online_status = $this->display_online_status;
            $this->user->railway_social->save();

            $this->alert('success', "Paramètre social mise à jour");
            $this->dispatch('closeModal', 'editSocial');
            $this->dispatch('refreshComponent');
        } catch (\Exception $exception) {
            \Log::emergency($exception->getMessage(), [$exception]);
            $this->alert('error', "Erreur lors de la sauvegarde des paramètres sociaux.");
        }
    }

    public function claim()
    {
        $this->alert("info", "Fonction bientôt disponible !");
        $this->dispatch('closeModal', 'claimVourcher');
    }

    #[On('refreshComponent')]
    public function refreshComponent()
    {
        $this->dispatch('$refresh');
    }

    public function render()
    {
        if(empty($this->code)) {
            $this->btnIsDisabled = true;
        }
        return view('livewire.account.profil-card-user');
    }
}
