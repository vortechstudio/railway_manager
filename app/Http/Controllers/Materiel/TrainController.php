<?php

namespace App\Http\Controllers\Materiel;

use App\Http\Controllers\Controller;

class TrainController extends Controller
{
    public function index()
    {
        return view('games.materiel.train.index');
    }
    public function buy()
    {
        return view('games.materiel.train.buy');
    }

    public function checkout()
    {
        if (auth()->user()->userRailwayHub()->where('active', true)->count() == 0) {
            toastr()->addError("Veuillez d'abord acheter un HUB !");

            return redirect()->route('train.buy');
        }

        return view('games.materiel.train.checkout');
    }

    public function rental()
    {
        if (auth()->user()->userRailwayHub()->where('active', true)->count() == 0) {
            toastr()->addError("Veuillez d'abord acheter un HUB !");

            return redirect()->route('train.buy');
        }

        return view('games.materiel.train.rental');
    }
}
