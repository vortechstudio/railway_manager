<?php

namespace App\Services;

class RailwayService
{
    public function getRailwayService()
    {
        return \Http::withoutVerifying()->get('https://manager.'.config('app.domain').'/api/services', [
            'service_name' => 'Railway Manager'
        ])->object();
    }
}
