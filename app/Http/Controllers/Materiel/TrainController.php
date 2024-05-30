<?php

namespace App\Http\Controllers\Materiel;

use App\Http\Controllers\Controller;

class TrainController extends Controller
{
    public function buy()
    {
        return view('games.materiel.train.buy');
    }

    public function checkout()
    {
        return view('games.materiel.train.checkout');
    }

    public function rental()
    {
        return view('games.materiel.train.rental');
    }
}
