<?php

namespace App\Http\Controllers;

use App\Models\Railway\Core\ShopItem;
use Illuminate\Http\Request;

class ShopController extends Controller
{
    public function index(Request $request)
    {
        if ($request->get('paymentStatement') == 'success') {

            $item = ShopItem::find($request->get('item'));

            match ($item->section) {
                'tpoint' => $this->checkoutTpoint($item),
            };

            toastr()
                ->addSuccess('Paiement effectuer avec succès, le produit à été ajouter à votre compte', 'Achat Effectuer');
        }

        return view('shop.index');
    }

    private function checkoutTpoint(ShopItem|\LaravelIdea\Helper\App\Models\Railway\Core\_IH_ShopItem_C|array|null $item): void
    {
        auth()->user()->railway->tpoint += $item->qte;
        auth()->user()->railway->save();
    }
}
