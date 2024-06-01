<?php

namespace App\Actions;

class CheckoutAction
{
    public function checkoutTpoint(int $amount)
    {
        if ($amount >= auth()->user()->railway->tpoint) {
            return false;
        } else {
            auth()->user()->railway->tpoint -= $amount;
            auth()->user()->railway->save();

            return true;
        }
    }
}
