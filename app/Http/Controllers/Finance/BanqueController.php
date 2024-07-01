<?php

namespace App\Http\Controllers\Finance;

use App\Http\Controllers\Controller;
use App\Models\Railway\Config\RailwayBanque;

class BanqueController extends Controller
{
    public function index()
    {
        return view('games.finance.banque.index');
    }

    public function show(int $banque_id)
    {
        $banque = RailwayBanque::with('fluxes', 'userRailwayEmprunts')
            ->find($banque_id);
        return view('games.finance.banque.show', ['banque' => $banque]);
    }

    public function repay(int $banque_id, int $emprunt_id)
    {
        $emprunt = auth()->user()->railway->userRailwayEmprunts()->find($emprunt_id);
        return view('games.finance.banque.repay', ['emprunt' => $emprunt]);
    }
}
