<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;

class PlanningController extends Controller
{
    public function index()
    {
        return view('games.network.planning.index');
    }

    public function editing()
    {
        return view('games.network.planning.editing');
    }
}
