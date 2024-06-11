<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;
use App\Models\User\User;

class RankController extends Controller
{
    public function __invoke()
    {
        return view('games.company.rank');
    }
}
