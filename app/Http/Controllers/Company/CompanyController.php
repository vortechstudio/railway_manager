<?php

namespace App\Http\Controllers\Company;

use App\Http\Controllers\Controller;

class CompanyController extends Controller
{
    public function __invoke()
    {
        return view('games.company.index');
    }
}
