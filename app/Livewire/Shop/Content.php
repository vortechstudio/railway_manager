<?php

namespace App\Livewire\Shop;

use App\Models\Config\Shop;
use App\Models\Railway\Core\ShopItem;
use App\Services\RailwayService;
use Livewire\Component;

class Content extends Component
{
    public Shop $shop;

    public int $shop_category_id = 0;

    public function mount(): void
    {
        $service = (new RailwayService())->getRailwayService();
        $this->shop = Shop::where('service_id', $service->id)->first();
    }

    public function selectCategory(int $category_id): void
    {
        $this->shop_category_id = $category_id;
    }

    public function checkout(int $item_id): void
    {
        $item = ShopItem::with('shopCategory', 'packages')->find($item_id);
        $this->dispatch('showModalCheckout', [
            'id' => 'modalCheckout',
            'item' => $item,
        ]);
    }

    public function render()
    {
        return view('livewire.shop.content');
    }
}
