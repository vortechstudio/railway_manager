<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;
use App\Models\User\Railway\UserRailwayHub;

class NetworkController extends Controller
{
    public function __invoke()
    {
        return view('games.network.index', [
            'hubs' => UserRailwayHub::with('railwayHub', 'userRailwayLigne', 'railwayHub.gare', 'userRailwayLigne.railwayLigne', 'userRailwayLigne.railwayLigne.stations', 'userRailwayLigne.railwayLigne.stations.gare')
                ->where('user_id', auth()->id())
                ->get(),
        ]);
    }
}
