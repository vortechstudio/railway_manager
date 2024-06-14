<?php

namespace App\Http\Controllers\Research;

use App\Http\Controllers\Controller;

class ResearchController extends Controller
{
    public function index()
    {
        return view('games.research.index');
    }
}
