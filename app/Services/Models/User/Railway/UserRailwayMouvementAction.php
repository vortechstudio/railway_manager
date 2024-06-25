<?php

namespace App\Services\Models\User\Railway;

use App\Models\User\Railway\UserRailwayMouvement;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Support\Collection;

class UserRailwayMouvementAction
{
    public function __construct(private ?UserRailwayMouvement $mouvement = null)
    {
    }

    /**
     * Get ecritures based on specified filters.
     *
     * @param Carbon|null $from The start date for filtering ecritures. Optional.
     * @param Carbon|null $to The end date for filtering ecritures. Optional.
     * @param string|null $type_amount The type of amount for filtering ecritures. Optional.
     * @param string|null $type_mvm The type of movement for filtering ecritures. Optional.
     * @param int|null $user_ligne_id The user ligne ID for filtering ecritures. Optional.
     * @param int|null $user_hub_id The user hub ID for filtering ecritures. Optional.
     *
     * @return Collection                A collection of ecritures matching the specified filters.
     */
    public function getEcritures(
        ?Carbon $from = null,
        ?Carbon $to = null,
        ?string $type_amount = null,
        ?string $type_mvm = null,
        ?int $user_ligne_id = null,
        ?int $user_hub_id = null,
    )
    {
        return auth()->user()->railway_company->mouvements()
            ->when($from && $to, fn(Builder $query) => $query->whereBetween('created_at', [$from, $to]))
            ->when($type_amount, fn(Builder $query) => $query->where('type_amount', $type_amount))
            ->when($type_mvm, fn(Builder $query) => $query->where('type_mvm', $type_mvm))
            ->when($user_hub_id, fn(Builder $query) => $query->where('user_railway_hub_id', $user_hub_id))
            ->when($user_ligne_id, fn(Builder $query) => $query->where('user_railway_ligne_id', $user_ligne_id))
            ->get();
    }

    /**
     * Get the sum of ecritures based on specified filters.
     *
     * @param Carbon|null $from The start date for filtering ecritures. Optional.
     * @param Carbon|null $to The end date for filtering ecritures. Optional.
     * @param string|null $type_amount The type of amount for filtering ecritures. Optional.
     * @param string|null $type_mvm The type of movement for filtering ecritures. Optional.
     * @param int|null $user_ligne_id The user ligne ID for filtering ecritures. Optional.
     * @param int|null $user_hub_id The user hub ID for filtering ecritures. Optional.
     *
     * @return float                The sum of amount for the matching ecritures.
     */
    public function getSumEcritures(
        ?Carbon $from = null,
        ?Carbon $to = null,
        ?string $type_amount = null,
        ?string $type_mvm = null,
        ?int $user_ligne_id = null,
        ?int $user_hub_id = null,
    )
    {
        return auth()->user()->railway_company->mouvements()
            ->when($from && $to, fn(Builder $query) => $query->whereBetween('created_at', [$from, $to]))
            ->when($type_amount, fn(Builder $query) => $query->where('type_amount', $type_amount))
            ->when($type_mvm, fn(Builder $query) => $query->where('type_mvm', $type_mvm))
            ->when($user_hub_id, fn(Builder $query) => $query->where('user_railway_hub_id', $user_hub_id))
            ->when($user_ligne_id, fn(Builder $query) => $query->where('user_railway_ligne_id', $user_ligne_id))
            ->sum('amount');
    }
}
