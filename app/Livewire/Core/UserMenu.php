<?php

namespace App\Livewire\Core;

use App\Services\RailwayService;
use Livewire\Component;

class UserMenu extends Component
{
    public $articles;

    public function mount()
    {
        $this->articles = (new RailwayService())->getRailwayArticles();
    }
    public function render()
    {
        return view('livewire.core.user-menu', [
            'articles' => json_encode($this->articles),
            'countMessage' => auth()->user()->railway_messages()->where('is_read', false)->get()->count(),
        ]);
    }
}
