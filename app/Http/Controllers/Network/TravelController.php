<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;
use App\Models\Railway\Planning\RailwayPlanning;

class TravelController extends Controller
{
    public function show(int $travel_id)
    {
        $planning = RailwayPlanning::find($travel_id);

        return view('games.network.travel.index', [
            "planning" => $planning
        ]);
    }
}
