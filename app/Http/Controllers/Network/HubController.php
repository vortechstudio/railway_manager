<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;
use App\Models\User\Railway\UserRailwayHub;

class HubController extends Controller
{
    public function show(int $hub_id)
    {
        $hub = UserRailwayHub::find($hub_id);
        return view('games.network.hub.index', [
            'hub' => $hub,
        ]);
    }
}
