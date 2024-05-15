<?php

namespace App\Livewire\Shop;

use App\Models\Config\Shop;
use App\Services\RailwayService;
use Livewire\Component;

class Content extends Component
{
    public Shop $shop;
    public int $shop_category_id = 0;

    public function mount()
    {
        $service = (new RailwayService())->getRailwayService();
        $this->shop = Shop::where('service_id', $service->id)->first();
    }

    public function selectCategory(int $category_id)
    {
        $this->shop_category_id = $category_id;
    }

    public function render()
    {
        return view('livewire.shop.content');
    }
}
