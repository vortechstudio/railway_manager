<?php

namespace App\Livewire\Core;

use App\Models\Social\Article;
use App\Services\RailwayService;
use Livewire\Component;

class NewsPanel extends Component
{
    public $selectedNotice = null;

    public function read(int $notice_id): void
    {
        $this->selectedNotice = $notice_id;
    }

    public function render()
    {
        $service = (new RailwayService())->getRailwayService();

        return view('livewire.core.news-panel', [
            'article_promote' => Article::where('published', true)
                ->where('cercle_id', $service->cercle_id)
                ->where('status', 'published')
                ->where('type', 'news')
                ->where('promote', true)
                ->first(),
            'articles' => Article::where('published', true)
                ->where('cercle_id', $service->cercle_id)
                ->where('type', 'news')
                ->orderBy('published_at', 'desc')
                ->limit(5)
                ->get(),
            'notices' => Article::where('published', true)
                ->where('cercle_id', $service->cercle_id)
                ->where('type', 'notice')
                ->orderBy('published_at', 'desc')
                ->get(),
        ]);
    }
}
