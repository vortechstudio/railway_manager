<?php

namespace App\Http\Controllers\Materiel;

use App\Http\Controllers\Controller;
use App\Models\User\Railway\UserRailwayEngine;

class TrainController extends Controller
{
    public function index()
    {
        return view('games.materiel.train.index');
    }

    public function show(int $user_railway_engine_id)
    {
        $engine = UserRailwayEngine::find($user_railway_engine_id);
        if ($engine->user->id !== auth()->user()->id) {
            toastr()
                ->addError('Accès non autoriser');

            return redirect()->back();
        }

        return view('games.materiel.train.show', [
            'engine' => $engine,
        ]);
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
