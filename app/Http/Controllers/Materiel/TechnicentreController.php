<?php

namespace App\Http\Controllers\Materiel;

use App\Http\Controllers\Controller;

class TechnicentreController extends Controller
{
    public function index()
    {
        return view('games.materiel.technicentre.index');
    }
}
