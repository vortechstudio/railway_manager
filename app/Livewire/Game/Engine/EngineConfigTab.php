<?php

namespace App\Livewire\Game\Engine;

use App\Actions\CheckoutAction;
use App\Actions\ErrorDispatchHandle;
use App\Actions\Railway\EngineAction;
use App\Models\User\Railway\UserRailwayEngine;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;

class EngineConfigTab extends Component
{
    use LivewireAlert;

    public UserRailwayEngine $engine;

    public function generateNumber(): void
    {
        $this->alert('question', "La génération d'un nouveau numéro vous coutera <strong>2 Tpoint</strong>, êtes-vous sur de vouloir générer un nouveau numéro ?", [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Oui',
            'onConfirmed' => 'confirmedNumber',
            'toast' => false,
            'allowOutsideClick' => false,
            'timer' => null,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Non',
            'cancelButtonColor' => '#ef5350',
        ]);
    }

    #[On('confirmedNumber')]
    public function confirmedNumber(): void
    {
        if ((new CheckoutAction())->checkoutTpoint(2)) {
            try {
                $this->engine->update([
                    'number' => (new EngineAction())->generateMissionCode($this->engine->railwayEngine, $this->engine->userRailwayHub),
                ]);
                $this->alert('success', 'Le numéro de rame à été générer avec succès !');
                $this->dispatch('refreshToolbar');
            } catch (\Exception $exception) {
                (new ErrorDispatchHandle())->handle($exception);
                $this->alert('error', 'Une erreur à eu lieu !');
            }
        }
    }

    public function render()
    {
        return view('livewire.game.engine.engine-config-tab');
    }
}
