<?php

namespace App\Livewire\Game\Network;

use App\Models\Railway\Config\RailwaySetting;
use App\Models\User\Railway\UserRailwayHub;
use App\Models\User\Railway\UserRailwayMouvement;
use Carbon\Carbon;
use Livewire\Component;

class HubRentParkingPanel extends Component
{
    public UserRailwayHub $hub;

    public float|int $caTomorrow = 0;

    public float|int $caToday = 0;

    public function mount()
    {
        $price_parking = RailwaySetting::where('name', 'price_parking')->first()->value;
        $nb_voyageur_hub = 0;

        foreach ($this->hub->plannings()->whereBetween('date_depart', [now()->startOfDay(), now()])->get() as $planning) {
            foreach ($planning->passengers as $passenger) {
                $nb_voyageur_hub += $passenger->nb_passengers;
            }
        }

        $this->caTomorrow = UserRailwayMouvement::whereDate('created_at', Carbon::tomorrow())
            ->where('type_mvm', 'parking')
            ->sum('amount');
        $this->caToday = ($price_parking * 20) * $nb_voyageur_hub;
    }

    public function render()
    {
        return view('livewire.game.network.hub-rent-parking-panel');
    }
}
