<?php

namespace App\Livewire\Game\Research;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Actions\Railway\CheckoutAction;
use App\Livewire\Core\Toolbar;
use App\Models\User\Railway\UserRailwayHub;
use App\Services\Models\User\Railway\UserRailwayHubAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ResearchInfraHubCard extends Component
{
    use LivewireAlert;
    public UserRailwayHub $hub;
    public string $alertHub = '';
    public int $last_level = 0;
    public bool $blocked = false;
    public int $baseAmount = 25000;
    public int $newAmount = 0;
    public int $newLevel;

    public function mount()
    {
        $this->blockAndAlertIfLevelIsLow(10);
        $this->blockAndAlertIfLevelIsLow(20);
        $this->blockAndAlertIfLevelIsLow(30);
        $this->blockAndAlertIfLevelIsLow(40);
        if ($this->hub->level == 50) {
            $this->blocked = true;
            $this->alertHub = "Niveau Maximal atteint";
        }
        $this->last_level = $this->hub->level;
    }

    public function updated()
    {
        $this->blockAndAlertIfLevelIsLow(10);
        $this->blockAndAlertIfLevelIsLow(20);
        $this->blockAndAlertIfLevelIsLow(30);
        $this->blockAndAlertIfLevelIsLow(40);
        if ($this->hub->level == 50) {
            $this->blocked = true;
            $this->alertHub = "Niveau Maximal atteint";
        }
    }

    public function claim()
    {
        $nextLevel = $this->hub->level + 1;
        $this->newAmount = $this->baseAmount + ($this->baseAmount * (1.785 * $nextLevel) / 100);

        $this->alert('question', "Passage au niveau supérieur", [
            'title' => "Passage au niveau supérieur {$this->hub->level} => {$nextLevel}",
            'toast' => false,
            'position' => 'center',
            'showConfirmButton' => true,
            'confirmButtonText' => \Helpers::eur($this->newAmount),
            'onConfirmed' => 'confirmed',
            'timer' => null,
            'allowOutsideClick' => false,
            'showCancelButton' => true,
            'cancelButtonText' => 'Annuler',
            'cancelButtonColor' => '#ef5350',
        ]);
    }

    #[On('confirmed')]
    public function udpateSystemHub()
    {
        try {
            if((new CheckoutAction())->checkoutArgent($this->newAmount)) {
                (new Compta())->create(
                    user: auth()->user(),
                    title: 'Amélioration du hub: '.$this->hub->railwayHub->gare->name,
                    amount: $this->newAmount,
                    type_amount: 'charge',
                    type_mvm: 'research',
                    valorisation: false,
                    user_railway_hub_id: $this->hub->id,
                );

                $this->hub->update([
                    'level' => $this->hub->level + 1,
                    'ligne_limit' => intval((new UserRailwayHubAction($this->hub))->getNextLevelStatus('ligne_limit')),
                    'commerce_limit' => intval((new UserRailwayHubAction($this->hub))->getNextLevelStatus('commerce')),
                    'publicity_limit' => intval((new UserRailwayHubAction($this->hub))->getNextLevelStatus('publicity')),
                    'parking_limit' => intval((new UserRailwayHubAction($this->hub))->getNextLevelStatus('parking')),
                ]);
                $this->newLevel = $this->hub->level;

                $this->alert('success', 'Niveau Supérieur !', [
                    'toast' => false,
                    'timer' => null,
                    'showCancelButton' => true,
                    'cancelButtonText' => 'OK',
                    'position' => 'center',
                    'html' => $this->getUpdateTextLevel()
                ]);
                $this->dispatch('refreshToolbar')->to(Toolbar::class);
            } else {
                $this->alert('error', "Vous n'avez pas les fonds nécessaires pour faire évoluer votre hub");
            }
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', "Une erreur à eu lieu");
        }
    }

    public function getUpdateTextLevel()
    {
        ob_start();
        ?>
        <div class="d-flex justify-content-around align-items-center">
            <span class="fs-2 text-gray-500 animate__animated animate__backInLeft"><?= $this->newLevel - 1 ?></span>
            <span class="fs-2 text-gray-500 animate__animated animate__backInUp animate__delay-1">-></span>
            <span class="fs-2 text-gray-500 animate__animated animate__backInUp animate__delay-2"><?= $this->newLevel ?></span>
        </div>
        <?php
        return ob_get_clean();
    }

    private function blockAndAlertIfLevelIsLow($requiredLevel) {
        $userLevel = auth()->user()->railway->level;
        if ($userLevel <= $requiredLevel && $this->hub->level == $requiredLevel) {
            $this->blocked = true;
            $this->alertHub = "Votre niveau de compagnie doit d'abord être augmenter";
        }
    }

    public function render()
    {
        return view('livewire.game.research.research-infra-hub-card');
    }
}
