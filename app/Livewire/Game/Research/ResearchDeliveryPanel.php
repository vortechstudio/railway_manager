<?php

namespace App\Livewire\Game\Research;

use App\Models\User\Railway\UserRailwayDelivery;
use App\Models\User\Railway\UserResearchDelivery;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ResearchDeliveryPanel extends Component
{
    use LivewireAlert;

    public UserRailwayDelivery $delivery;

    public function accelerate(int $delivery_id)
    {

    }

    public function render()
    {
        return view('livewire.game.research.research-delivery-panel', [
            'deliveries' => UserResearchDelivery::where('user_railway_id', auth()->user()->railway->id)
                ->get(),
        ]);
    }
}
