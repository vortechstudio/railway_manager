<?php

namespace App\Livewire\Auth;

use App\Actions\ErrorDispatchHandle;
use App\Services\Models\User\NewUserSetupAction;
use Livewire\Component;

class Install extends Component
{
    public string $name_company = '';
    public string $desc_company = '';
    public string $name_secretary = '';
    public bool $tos = false;

    public function save()
    {
        try {
            (new NewUserSetupAction(auth()->user()))->updateUserRailway($this->all());
            (new NewUserSetupAction(auth()->user()))->createUserSocialCompanyBonus();
            (new NewUserSetupAction(auth()->user()))->loginAndSendWelcomeMessage();
            $this->redirectRoute('home');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

    public function render()
    {
        return view('livewire.auth.install');
    }
}
