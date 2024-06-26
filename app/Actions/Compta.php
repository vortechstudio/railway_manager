<?php

namespace App\Actions;

use App\Models\User\User;

class Compta
{
    private const CHARGE = 'charge';

    /**
     * Create a new railway record for a user
     *
     * @param  User  $user  The user for whom the record will be created
     * @param  string  $title  The title of the railway record
     * @param  float|int|string  $amount  The amount of the railway record
     * @param  string  $type_amount  The type of the amount (e.g. CHARGE or PAYMENT)
     * @param  string  $type_mvm  The type of the movement (e.g. INCOME or EXPENSE)
     * @param  bool  $valorisation  (optional) Whether to update the balance and valorisation (default is true)
     */
    public function create(User $user, string $title, float|int|string $amount, string $type_amount, string $type_mvm, bool $valorisation = true, ?int $user_railway_ligne_id = null, ?int $user_railway_hub_id = null): void
    {
        $isCharge = $type_amount == self::CHARGE;
        $amountVal = floatval($amount);
        $amountVal = $isCharge ? -$amountVal : $amountVal;

        try {
            $user->railway_company->mouvements()->create([
                'title' => $title,
                'amount' => $amountVal,
                'type_amount' => $type_amount,
                'type_mvm' => $type_mvm,
                'user_railway_company_id' => $user->railway_company->id,
                'user_railway_ligne_id' => $user_railway_ligne_id,
                'user_railway_hub_id' => $user_railway_hub_id,
            ]);
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }

        $this->updateBalanceAndValorisation($user, $amountVal, $valorisation, $isCharge);
    }

    /**
     * Update the balance and valorisation of a user's railway account.
     *
     * @param  User  $user  The user whose railway account needs to be updated.
     * @param  float  $amountVal  The amount to be added to the user's railway account balance and valorisation.
     * @param  bool  $valorisation  Indicates whether to update the valorisation of the user's railway company.
     */
    private function updateBalanceAndValorisation(User $user, float $amountVal, bool $valorisation): void
    {
        try {
            $railway = $user->railway;
            $railway->argent += $amountVal;
            $railway->save();

            if ($valorisation) {
                $railway_company = $user->railway_company;
                $railway_company->valorisation += $amountVal;
                $railway_company->save();
            }
        } catch (\Exception $exception) {
            (new ErrorDispatchHandle())->handle($exception);
        }
    }
}
