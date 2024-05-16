<?php

namespace App\Livewire\Shop;

use App\Models\Railway\Core\ShopItem;
use App\Models\Railway\Engine\RailwayEngine;
use App\Models\User\User;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class ModalCheckout extends Component
{
    use LivewireAlert;

    public User $user;

    public function mount()
    {
        $this->user = \Auth::user();
    }

    public function passCheckout(int $item_id)
    {
        $item = ShopItem::with('packages', 'shopCategory')->find($item_id);
        $checkout = match ($item->currency_type) {
            "argent" => $this->checkoutArgent($item),
            "tpoint" => $this->checkoutTpoint($item),
            "reel" => $this->checkoutReel($item),
        };
    }

    public function checkoutTpoint(ShopItem $item)
    {
        if($item->section == 'engine') {
            $engine = RailwayEngine::where('name', 'like', '%'.$item->name.'%')->first();

            $this->user->railway->tpoint -= $item->price;
            $this->user->railway->save();

            // Ajout du matériel roulant dans le compte client


            $this->dispatch('closeModal', 'modalCheckout');
            $this->dispatch('showModalPassCheckout', [
                'id' => 'modalPassCheckout',
                'item' => $item
            ]);
        }
    }


    public function render()
    {
        return view('livewire.shop.modal-checkout');
    }

    private function checkoutReel(\Illuminate\Database\Eloquent\Model|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|ShopItem|\LaravelIdea\Helper\App\Models\Railway\Core\_IH_ShopItem_C|\LaravelIdea\Helper\App\Models\Railway\Core\_IH_ShopItem_QB|null $item)
    {
        if($item->section == 'engine') {

        } elseif ($item->section == 'tpoint') {
            Stripe::setApiKey(config('services.stripe.secret'));
            $checkout_session = Session::create([
                'line_items' => [[
                    'price' => $item->stripe_token,
                    'quantity' => 1
                ]],
                'mode' => 'payment',
                'success_url' => config('app.url').'/shop?paymentStatement=success&item='.$item->id,
                'cancel_url' => config('app.url').'/shop',
                'automatic_tax' => [
                    'enabled' => true,
                ],
            ]);

            $this->redirect($checkout_session->url);
        }
    }
}