<?php

namespace App\Http\Controllers;

class NewsController extends Controller
{
    public function __invoke()
    {
        return view('news');
    }
}
