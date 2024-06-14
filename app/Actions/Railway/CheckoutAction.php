<?php

namespace App\Actions\Railway;

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

    public function checkoutResearch(int $amount)
    {
        if ($amount >= auth()->user()->railway->research) {
            return false;
        } else {
            auth()->user()->railway->research -= $amount;
            auth()->user()->railway->save();

            return true;
        }
    }
}
