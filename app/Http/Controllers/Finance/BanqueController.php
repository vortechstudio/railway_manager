<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;

class BanqueController extends Controller
{
    public function index()
    {
        return view('games.finance.banque.index');
    }
}
