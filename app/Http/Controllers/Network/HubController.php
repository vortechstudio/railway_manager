<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;
use App\Models\Railway\Gare\RailwayHub;
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

    public function buy()
    {
        $hubs = RailwayHub::with('gare', 'lignes')->where('active', true);
        if (config('app.env') == 'production') {
            $hubs->where('status', 'production');
        } else {
            $hubs->where('status', 'beta');
        }

        return view('games.network.hub.buy', [
            'hubs' => $hubs->get(),
        ]);
    }
}
