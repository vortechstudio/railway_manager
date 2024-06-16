<?php

namespace App\Livewire\Game\Research;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Actions\Railway\CheckoutAction;
use App\Livewire\Core\Toolbar;
use App\Models\User\Railway\UserRailwayLigne;
use App\Services\Models\User\Railway\UserRailwayLigneAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class ResearchInfraLigneCard extends Component
{
    use LivewireAlert;

    public UserRailwayLigne $ligne;

    public string $alertLigne = '';

    public bool $blocked = false;

    public int $baseAmount = 10000;

    public int $newAmount = 0;

    public int $newLevel;

    public function mount()
    {
        $this->blockAndAlertIfLevelIsLow(10);
        $this->blockAndAlertIfLevelIsLow(20);
        $this->blockAndAlertIfLevelIsLow(30);
        $this->blockAndAlertIfLevelIsLow(40);
        if ($this->ligne->level == 50) {
            $this->blocked = true;
            $this->alertLigne = 'Niveau Maximal atteint';
        }
    }

    public function updated()
    {
        $this->blockAndAlertIfLevelIsLow(10);
        $this->blockAndAlertIfLevelIsLow(20);
        $this->blockAndAlertIfLevelIsLow(30);
        $this->blockAndAlertIfLevelIsLow(40);
        if ($this->ligne->level == 50) {
            $this->blocked = true;
            $this->alertLigne = 'Niveau Maximal atteint';
        }
    }

    public function claim()
    {
        $nextLevel = $this->ligne->level + 1;
        $this->newAmount = $this->baseAmount + ($this->baseAmount * (1.320 * $nextLevel) / 100);

        $this->alert('question', 'Passage au niveau supérieur', [
            'title' => "Passage au niveau supérieur {$this->ligne->level} => {$nextLevel}",
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
    public function udpateSystemLigne()
    {
        try {
            if ((new CheckoutAction())->checkoutArgent($this->newAmount)) {
                (new Compta())->create(
                    user: auth()->user(),
                    title: 'Amélioration de ligne: '.$this->ligne->railwayLigne->name,
                    amount: $this->newAmount,
                    type_amount: 'charge',
                    type_mvm: 'research',
                    valorisation: false,
                    user_railway_ligne_id: $this->ligne->id,
                    user_railway_hub_id: $this->ligne->userRailwayHub->id,
                );

                $this->ligne->update([
                    'level' => $this->ligne->level + 1,
                    'nb_depart_jour' => intval((new UserRailwayLigneAction($this->ligne))->getLevelNextStatus('nb_depart_jour')),
                ]);
                $this->newLevel = $this->ligne->level;

                $this->alert('success', 'Niveau Supérieur !', [
                    'toast' => false,
                    'timer' => null,
                    'showCancelButton' => true,
                    'cancelButtonText' => 'OK',
                    'position' => 'center',
                    'html' => $this->getUpdateTextLevel(),
                ]);
                $this->dispatch('refreshToolbar')->to(Toolbar::class);
            } else {
                $this->alert('error', "Vous n'avez pas les fonds nécessaires pour faire évoluer votre ligne");
            }
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu');
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

    private function blockAndAlertIfLevelIsLow($requiredLevel)
    {
        $userLevel = auth()->user()->railway->level;
        if ($userLevel <= $requiredLevel && $this->ligne->level == $requiredLevel) {
            $this->blocked = true;
            $this->alertLigne = "Votre niveau de compagnie doit d'abord être augmenter";
        }
    }

    public function render()
    {
        return view('livewire.game.research.research-infra-ligne-card');
    }
}
