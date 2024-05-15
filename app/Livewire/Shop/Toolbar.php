<?php

namespace App\Livewire\Shop;

use Livewire\Component;

class Toolbar extends Component
{
    public int $argent = 0;
    public int $tpoint = 0;

    public function boot()
    {
        $this->argent = auth()->user()->railway->argent;
        $this->tpoint = auth()->user()->railway->tpoint;
    }

    public function render()
    {
        return view('livewire.shop.toolbar');
    }
}
