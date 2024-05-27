<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;
use App\Models\User\Railway\UserRailwayLigne;

class LineController extends Controller
{
    public function show(int $line_id)
    {
        $ligne = UserRailwayLigne::find($line_id);

        return view('games.network.line.index', [
            'ligne' => $ligne,
        ]);
    }
}
