<?php

namespace App\Http\Controllers\Account;

use App\Http\Controllers\Controller;

class AccountController extends Controller
{
    public function profil()
    {
        return view('account.profil');
    }

    public function leveling()
    {
        return view('account.leveling');
    }
}
