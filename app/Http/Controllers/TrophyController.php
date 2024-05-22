<?php

namespace App\Http\Controllers;

class TrophyController extends Controller
{
    public function index()
    {
        return view('trophy.index');
    }

    public function show(string $sector)
    {
        return view('trophy.show', [
            'sector' => $sector,
        ]);
    }
}
