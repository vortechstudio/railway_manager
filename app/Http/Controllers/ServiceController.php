<?php

namespace App\Http\Controllers;

class ServiceController extends Controller
{
    public function __invoke()
    {
        return view('games.services');
    }
}
