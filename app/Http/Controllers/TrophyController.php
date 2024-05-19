<?php

namespace App\Http\Controllers;

use App\Models\Railway\Core\Achievement;

class TrophyController extends Controller
{
    public function index()
    {
        return view('trophy.index');
    }

    public function show(string $sector)
    {
        return view('trophy.show', [
            'sector' => $sector
        ]);
    }
}
