<?php

namespace App\Services\Models\User\Railway;

use App\Models\Railway\Config\RailwayBanque;
use App\Models\User\Railway\UserRailway;
use App\Models\User\Railway\UserRailwayEmprunt;

class UserRailwayEmpruntAction
{
    public function __construct(private ?UserRailwayEmprunt $emprunt = null)
    {
    }

    public function getLatestFluxOfMarket(RailwayBanque $banque, UserRailway $userRailway)
    {
        $bank_note = $userRailway->bank_note;

        if ($bank_note >= 0 && $bank_note <= 10) {
            return $banque->latest_flux + 1.09;
        } elseif ($bank_note > 10 && $bank_note <= 20) {
            return $banque->latest_flux + 0.98;
        } elseif ($bank_note > 20 && $bank_note <= 30) {
            return $banque->latest_flux + 0.84;
        } elseif ($bank_note > 30 && $bank_note <= 40) {
            return $banque->latest_flux + 0.72;
        } elseif ($bank_note > 40 && $bank_note <= 50) {
            return $banque->latest_flux + 0.60;
        } elseif ($bank_note > 50 && $bank_note <= 60) {
            return $banque->latest_flux + 0.42;
        } elseif ($bank_note > 60 && $bank_note <= 70) {
            return $banque->latest_flux + 0.27;
        } elseif ($bank_note > 70 && $bank_note <= 80) {
            return $banque->latest_flux + 0.19;
        } elseif ($bank_note > 80 && $bank_note <= 90) {
            return $banque->latest_flux + 0.07;
        } else {
            return $banque->latest_flux;
        }
    }

    public function stylizingStatus(string $type)
    {
        return match ($type) {
            "color" => match ($this->emprunt->status->value) {
                'pending' => 'warning',
                'terminated' => 'success'
            },
            'text' => match ($this->emprunt->status->value) {
                'pending' => 'En cours...',
                'terminated' => 'Terminer'
            },
            'icon' => match ($this->emprunt->status->value) {
                'pending' => 'fa-exchange-alt',
                'terminated' => 'fa-check-circle'
            },
        };
    }

    public function restPendingExpress(int $banque_id)
    {
        $banque = RailwayBanque::find($banque_id);
        $pending = auth()->user()->railway->userRailwayEmprunts
            ->where('status', 'pending')
            ->where('type_emprunt', 'express')
            ->where('railway_banque_id', $banque_id)
            ->sum('amount_emprunt');
        $charge = auth()->user()->railway->userRailwayEmprunts
            ->where('status', 'pending')
            ->where('type_emprunt', 'express')
            ->where('railway_banque_id', $banque_id)
            ->sum('charge');
        return $banque->express_base - ($pending - $charge);
    }

    public function restPendingMarket(int $banque_id)
    {
        $banque = RailwayBanque::find($banque_id);
        $pending = auth()->user()->railway->userRailwayEmprunts
            ->where('status', 'pending')
            ->where('type_emprunt', 'marche')
            ->where('railway_banque_id', $banque_id)
            ->sum('amount_emprunt');
        $charge = auth()->user()->railway->userRailwayEmprunts
            ->where('status', 'pending')
            ->where('type_emprunt', 'marche')
            ->where('railway_banque_id', $banque_id)
            ->sum('charge');
        return $banque->public_base - ($pending - $charge);
    }
}
