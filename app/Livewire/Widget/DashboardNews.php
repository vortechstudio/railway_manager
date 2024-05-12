<?php

namespace App\Livewire\Widget;

use App\Models\Social\Article;
use App\Services\RailwayService;
use Livewire\Component;

class DashboardNews extends Component
{
    public function render()
    {
        $service = (new RailwayService())->getRailwayService();
        return view('livewire.widget.dashboard-news', [
            'articles' => Article::where('cercle_id', $service->cercle_id)
                ->where('published', 1)
                ->where('promote', true)
                ->where('status', 'published')
                ->get()
        ]);
    }
}
