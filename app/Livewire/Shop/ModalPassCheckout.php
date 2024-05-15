<?php

namespace App\Livewire\Shop;

use App\Models\Railway\Core\ShopItem;
use App\Models\Railway\Engine\RailwayEngine;
use App\Models\User\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;

class ModalPassCheckout extends Component
{
    public function render()
    {
        return view('livewire.shop.modal-pass-checkout');
    }
}
