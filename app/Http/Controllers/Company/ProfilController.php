<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

class ProfilController extends Controller
{
    public function __invoke()
    {
        return view('games.company.profil');
    }
}
