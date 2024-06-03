<?php

namespace App\Livewire\Shop;

use App\Actions\CheckoutAction;
use App\Actions\Compta;
use App\Actions\Railway\EngineAction;
use App\Actions\ShopFunctionAction;
use App\Models\Railway\Core\ShopItem;
use App\Models\Railway\Engine\RailwayEngine;
use App\Models\User\User;
use App\Services\Models\Railway\Engine\RailwayEngineAction;
use App\Services\Models\User\Railway\UserRailwayEngineAction;
use Jantinnerezo\LivewireAlert\LivewireAlert;
use Livewire\Component;
use Stripe\Checkout\Session;
use Stripe\Stripe;

class ModalCheckout extends Component
{
    use LivewireAlert;

    public User $user;

    public function mount(): void
    {
        $this->user = \Auth::user();
    }

    public function passCheckout(int $item_id): void
    {
        $item = ShopItem::with('packages', 'shopCategory')->find($item_id);
        match ($item->currency_type) {
            'argent' => $this->checkoutArgent($item),
            'tpoint' => $this->checkoutTpoint($item),
            'reel' => $this->checkoutReel($item),
        };
    }

    public function checkoutTpoint(ShopItem $item): void
    {
        if ($item->section == 'engine') {
            $engine = RailwayEngine::where('name', 'like', '%'.$item->name.'%')->first();


            // Ajout du matériel roulant dans le compte client

            if((new CheckoutAction())->checkoutTpoint($item->price)) {
                auth()->user()->railway_engines()->create([
                    'number' => (new EngineAction())->generateMissionCode($engine, auth()->user()->userRailwayHub()->where('active', true)->first()),
                    'max_runtime' => (new RailwayEngineAction($engine))->maxRuntime(),
                    'available' => true,
                    'date_achat' => now(),
                    'status' => 'free',
                    'user_id' => auth()->user()->id,
                    'railway_engine_id' => $item->model_id,
                    'user_railway_hub_id' => auth()->user()->userRailwayHub()->where('active', true)->first()->id,
                    'active' => true,
                ]);
            } else {
                $this->alert("Vous n'avez pas assez de Travel Point pour cette achat !");
            }


            $this->dispatch('closeModal', 'modalCheckout');
            $this->dispatch('showModalPassCheckout', [
                'id' => 'modalPassCheckout',
                'item' => $item,
            ]);
        }
    }

    private function checkoutReel(\Illuminate\Database\Eloquent\Model|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|ShopItem|\LaravelIdea\Helper\App\Models\Railway\Core\_IH_ShopItem_C|\LaravelIdea\Helper\App\Models\Railway\Core\_IH_ShopItem_QB|null $item): void
    {
        if ($item->section == 'engine') {

        } elseif ($item->section == 'tpoint') {
            Stripe::setApiKey(config('services.stripe.secret'));
            $checkout_session = Session::create([
                'line_items' => [[
                    'price' => $item->stripe_token,
                    'quantity' => 1,
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

    private function checkoutArgent(\Illuminate\Database\Eloquent\Model|array|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|ShopItem|\LaravelIdea\Helper\App\Models\Railway\Core\_IH_ShopItem_C|\LaravelIdea\Helper\App\Models\Railway\Core\_IH_ShopItem_QB|null $item): void
    {
        $function = match ($item->section) {
            'simulation' => (new ShopFunctionAction())->executeSimulation($item, $this->user),
        };

        if ($function) {
            (new Compta())->create(
                $this->user,
                'Achat en boutique: '.$item->name,
                $item->price,
                'charge',
                'divers',
            );
            $this->dispatch('closeModal', 'modalCheckout');
            $this->dispatch('showModalPassCheckout', [
                'id' => 'modalPassCheckout',
                'item' => $item,
            ]);
        } else {
            $this->dispatch('closeModal', 'modalCheckout');
            $this->alert('error', 'Erreur lors de votre achat, veuillez réessayer ou contacter le support technique !');
        }
    }

    public function render()
    {
        return view('livewire.shop.modal-checkout');
    }
}
