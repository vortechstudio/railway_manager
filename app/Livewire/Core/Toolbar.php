<?php

namespace App\Livewire\Core;

use Livewire\Attributes\On;
use Livewire\Component;

class Toolbar extends Component
{
    public ?array $breads = null;

    public bool $notitle = false;

    public bool $alertFeature = false;

    public $argent;

    public $tpoint;

    public $research;

    public $level;

    public $xp;

    public $xp_percent;

    public function mount(): void
    {
        $this->argent = auth()->user()->railway->argent;
        $this->tpoint = auth()->user()->railway->tpoint;
        $this->research = auth()->user()->railway->research;
        $this->level = auth()->user()->railway->level;
        $this->xp = auth()->user()->railway->xp;
        $this->xp_percent = auth()->user()->railway->xp_percent;
    }

    #[On('refreshToolbar')]
    public function refreshToolbar(): void
    {
        $this->argent = auth()->user()->railway->argent;
        $this->tpoint = auth()->user()->railway->tpoint;
        $this->research = auth()->user()->railway->research;
        $this->level = auth()->user()->railway->level;
        $this->xp = auth()->user()->railway->xp;
        $this->xp_percent = auth()->user()->railway->xp_percent;
    }

    public function render()
    {
        return view('livewire.core.toolbar');
    }
}
