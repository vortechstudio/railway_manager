<?php

namespace App\Livewire\Auth;

use App\Actions\ErrorDispatchHandle;
use App\Models\User\User;
use App\Services\Models\User\NewUserSetupAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use ZxcvbnPhp\Zxcvbn;

class SetupView extends Component
{
    use LivewireAlert;
    public string $provider;
    public string $email;
    public string $password;
    public string $passwordStrength = 'Faible';
    public int $strengthScore = 0;
    public array $strengthLevels = [
        1 => 'Faible',
        2 => 'Moyen',
        3 => 'Bon',
        4 => 'Fort',
    ];
    public bool $visible = false;

    public string $name_company = '';
    public string $desc_company = '';
    public string $name_secretary = '';
    public bool $tos = false;

    public function updatedPassword($value)
    {
        $this->strengthScore = (new Zxcvbn())->passwordStrength($value)['score'];
    }

    public function save()
    {
        try {
            $user = User::where('email', $this->email)->firstOrFail();
            (new NewUserSetupAction($user))->updateUserPassword($this->password);
            (new NewUserSetupAction($user))->updateUserRailway($this->all());
            (new NewUserSetupAction($user))->createUserSocialCompanyBonus();
            (new NewUserSetupAction($user))->loginAndSendWelcomeMessage();
            $this->redirectRoute('home');
        }catch (\Exception $exception){
            (new ErrorDispatchHandle())->handle($exception);
        }
    }

    public function render()
    {
        return view('livewire.auth.setup-view');
    }
}
