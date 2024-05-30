<?php

namespace App\Livewire\Game\Network;

use App\Actions\Compta;
use App\Actions\ErrorDispatchHandle;
use App\Models\User\Railway\UserRailwayLigne;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Vortechstudio\Helpers\Facades\Helpers;

class LigneSelling extends Component
{
    use LivewireAlert;

    public UserRailwayLigne $ligne;

    public float $totalSelling = 0.00;

    public float $totalFlux = 0.00;

    public function mount(): void
    {
        $this->totalFlux = ($this->ligne->simulateSelling()) * $this->ligne->flux_market / 100;
        $this->totalSelling = ($this->ligne->simulateSelling()) + $this->totalFlux;
    }

    public function sell(): void
    {
        $this->alert('question', 'Etes-vous sur de vouloir vendre cette ligne pour '.Helpers::eur($this->totalSelling).' ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Vendre la ligne',
            'onConfirmed' => 'confirmed',
            'toast' => false,
            'allowOutsideClick' => false,
            'timer' => null,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Annuler',
            'cancelButtonColor' => '#ef5350',
        ]);
    }

    #[On('confirmed')]
    public function selling(): void
    {
        try {
            (new Compta())->create(
                user: auth()->user(),
                title: "Vente de la ligne: {$this->ligne->railwayLigne->start->name} / {$this->ligne->railwayLigne->start->name}",
                amount: $this->totalSelling,
                type_amount: 'revenue',
                type_mvm: 'vente_ligne',
            );

            $this->ligne->delete();
            $this->dispatch('refreshToolbar');
            $this->alert('success', 'Votre ligne à bien été vendue');
            $this->redirectRoute('network.index');
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
            $this->alert('error', 'Une erreur à eu lieu !');
        }
    }

    public function render()
    {
        return view('livewire.game.network.ligne-selling');
    }
}
