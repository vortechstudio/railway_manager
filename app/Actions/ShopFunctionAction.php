<?php

namespace App\Actions;

class ShopFunctionAction
{
    public function executeSimulation(\Illuminate\Database\Eloquent\Model|\Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Builder|\App\Models\Railway\Core\ShopItem|array|\LaravelIdea\Helper\App\Models\Railway\Core\_IH_ShopItem_C|\LaravelIdea\Helper\App\Models\Railway\Core\_IH_ShopItem_QB|null $item, \App\Models\User\User $user)
    {
        try {
            $user->railway_bonus->simulation += $item->qte;
            $user->railway_bonus->save();

            return true;
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);

            return false;
        }
    }
}
