<?php

namespace App\Livewire\Core;

use App\Models\Social\Article;
use App\Services\RailwayService;
use Livewire\Component;

class UserAnnonce extends Component
{
    public function render()
    {
        $service = (new RailwayService())->getRailwayService();

        return view('livewire.core.user-annonce', [
            'news' => Article::where('type', 'news')
                ->where('published', true)
                ->where('status', 'published')
                ->where('cercle_id', $service->cercle_id)
                ->limit(5)
                ->orderBy('published_at', 'desc')
                ->get(),
            'updates' => Article::where('type', 'notice')
                ->where('title', 'like', '%[MAJ]%')
                ->where('published', true)
                ->where('status', 'published')
                ->where('cercle_id', $service->cercle_id)
                ->limit(5)
                ->orderBy('published_at', 'desc')
                ->get(),
        ]);
    }
}
