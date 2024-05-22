<?php

namespace App\Http\Controllers\Network;

use App\Http\Controllers\Controller;

class NetworkController extends Controller
{
    public function __invoke()
    {
        return view('games.network.index');
    }
}
