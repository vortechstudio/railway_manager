<?php

namespace App\Livewire\Game\Network;

use App\Models\User\Railway\UserRailwayHub;
use Livewire\Component;

class LigneList extends Component
{
    public $type;

    public UserRailwayHub $hub;

    public $lignes;

    public function mount(): void
    {
        $this->lignes = match ($this->type) {
            default => auth()->user()->userRailwayLigne()->with('tarifs', 'railwayLigne')->where('active', true)->get(),
            'hub' => $this->hub->userRailwayLigne()->with('tarifs', 'railwayLigne')->where('active', true)->get(),
        };
    }

    public function render()
    {
        return view('livewire.game.network.ligne-list');
    }
}
