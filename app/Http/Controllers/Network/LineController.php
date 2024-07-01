<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;
use App\Models\User\Railway\UserRailwayLigne;

class LineController extends Controller
{
    public function show(int $line_id)
    {
        $ligne = UserRailwayLigne::with('railwayLigne', 'railwayLigne.stations', 'railwayLigne.stations.gare')->find($line_id);

        return view('games.network.line.index', [
            'ligne' => $ligne,
        ]);
    }

    public function buy()
    {
        $hubs = auth()->user()->userRailwayHub()->with('railwayHub')->where('active', true)->get();

        return view('games.network.line.buy', [
            'hubs' => $hubs,
        ]);
    }
}
