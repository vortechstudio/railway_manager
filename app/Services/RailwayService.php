<?php

namespace App\Services;

class RailwayService
{
    public function getRailwayService()
    {
        return \Http::withoutVerifying()->get('https://manager.'.config('app.domain').'/api/services', [
            'service_name' => 'Railway Manager',
        ])->object();
    }

    public function getRailwayArticles()
    {
        $service = $this->getRailwayService();

        return \Http::withoutVerifying()
            ->get('https://manager.'.config('app.domain').'/api/services/'.$service->id.'/articles')
            ->object();
    }
}
