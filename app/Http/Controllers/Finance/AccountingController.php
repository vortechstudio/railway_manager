<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;

class AccountingController extends Controller
{
    public function index()
    {
        return view('games.finance.accounting.index');
    }
}
