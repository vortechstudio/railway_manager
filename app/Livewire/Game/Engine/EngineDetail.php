<?php

namespace App\Livewire\Game\Engine;

use App\Livewire\FeatureBodyTrait;
use App\Models\User\Railway\UserRailwayEngine;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class EngineDetail extends Component
{
    use LivewireAlert, FeatureBodyTrait;
    public UserRailwayEngine $engine;

    public function welcoming()
    {
        $this->alert('warning', 'Système de Maintenance', [
            'toast' => false,
            'html' => $this->getBody(),
            'position' => 'center',
        ]);
    }

    public function render()
    {
        return view('livewire.game.engine.engine-detail');
    }
}
