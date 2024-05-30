<?php

namespace App\Livewire\Game\Core;

use App\Actions\CheckoutAction;
use App\Models\User\Railway\UserRailwayDelivery;
use App\Services\Models\User\Railway\UserRailwayDeliveryAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Attributes\On;
use Livewire\Component;
use Vortechstudio\Helpers\Facades\Helpers;

class DeliveryList extends Component
{
    use LivewireAlert;
    public $delivery;
    public function accelerate(int $delivery_id)
    {
        $this->delivery = UserRailwayDelivery::find($delivery_id);
        $this->alert('question', 'Etes-vous sur de vouloir accélérer cette livraison pour '.$this->delivery->end_at->diffInMinutes(now()).' Tpoint ?', [
            'showConfirmButton' => true,
            'confirmButtonText' => 'Oui',
            'onConfirmed' => 'confirmed',
            'toast' => false,
            'allowOutsideClick' => false,
            'timer' => null,
            'position' => 'center',
            'showCancelButton' => true,
            'cancelButtonText' => 'Non',
            'cancelButtonColor' => '#ef5350',
        ]);
    }

    #[On('confirmed')]
    public function confirmed()
    {
        if((new CheckoutAction())->checkoutTpoint($this->delivery->end_at->diffInMinutes(now()))) {
            (new UserRailwayDeliveryAction($this->delivery))->delivered();
            $this->dispatch('refreshToolbar');
        }
    }
    public function render()
    {
        return view('livewire.game.core.delivery-list');
    }
}
