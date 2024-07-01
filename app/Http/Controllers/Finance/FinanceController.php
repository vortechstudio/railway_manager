<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;

class FinanceController extends Controller
{
    public function __invoke()
    {
        return view('games.finance.index');
    }
}
