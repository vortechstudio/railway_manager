<?php

namespace App\Actions\Railway;

class EngineSelectAction
{
    /**
     * Returns a collection of available types of trains.
     *
     * @param  string|null  $search  The search parameter to filter the collection by.
     * @param  string|null  $field  The field to retrieve from the search result. Defaults to 'value'.
     * @return string|array|null Returns the value of the specified field if a search parameter is provided,
     *                           or returns the entire collection if no search parameter is provided.
     */
    public function selectorTypeTrain(?string $search = null, ?string $field = null): array|string|null
    {
        $arr = collect();
        $arr->push([
            'id' => 'motrice',
            'value' => 'Motrice',
            'coef' => 1.8,
        ]);
        $arr->push([
            'id' => 'voiture',
            'value' => 'Voiture',
            'coef' => 1.5,
        ]);
        $arr->push([
            'id' => 'automotrice',
            'value' => 'Automotrice',
            'coef' => 2,
        ]);
        $arr->push([
            'id' => 'bus',
            'value' => 'Bus',
            'coef' => 1.2,
        ]);

        if ($search != null) {
            return $arr->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $arr;
        }
    }

    /**
     * Retrieve the type of transport based on search criteria.
     *
     * @param  string|null  $search  The ID of the type to search for.
     * @param  string|null  $field  The field to retrieve, defaults to 'value'.
     * @return mixed The value of the specified field if $search is provided, otherwise the collection of transport types.
     */
    public function selectorTypeTransport(?string $search = null, ?string $field = null): mixed
    {
        $arr = collect();
        $arr->push([
            'id' => 'ter',
            'value' => 'TER',
            'image' => \Storage::url('icons/railway/transport/logo_ter.svg'),
        ]);
        $arr->push([
            'id' => 'tgv',
            'value' => 'TGV',
            'image' => \Storage::url('icons/railway/transport/logo_tgv.svg'),
        ]);
        $arr->push([
            'id' => 'intercity',
            'value' => 'Intercité',
            'image' => \Storage::url('icons/railway/transport/logo_intercite.svg'),
        ]);
        $arr->push([
            'id' => 'tram',
            'value' => 'TRAM',
            'image' => \Storage::url('icons/railway/transport/logo_tram.svg'),
        ]);
        $arr->push([
            'id' => 'metro',
            'value' => 'Metro',
            'image' => \Storage::url('icons/railway/transport/logo_metro.svg'),
        ]);
        $arr->push([
            'id' => 'other',
            'value' => 'Autre',
            'image' => \Storage::url('icons/railway/transport/default.png'),
        ]);

        if ($search != null) {
            return $arr->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $arr;
        }
    }

    /**
     * Retrieve the type of energy based on search criteria.
     *
     * @param  string|null  $search  The ID of the type to search for.
     * @param  string|null  $field  The field to retrieve, defaults to 'value'.
     * @return mixed The value of the specified field if $search is provided, otherwise the collection of energy types.
     */
    public function selectorTypeEnergy(?string $search = null, ?string $field = null): mixed
    {
        $arr = collect();
        $arr->push([
            'id' => 'diesel',
            'value' => 'Diesel',
            'coef' => 1.5,
        ]);
        $arr->push([
            'id' => 'vapeur',
            'value' => 'Vapeur',
            'coef' => 1.2,
        ]);
        $arr->push([
            'id' => 'electrique',
            'value' => 'Electrique',
            'coef' => 2.2,
        ]);
        $arr->push([
            'id' => 'hybride',
            'value' => 'Hybride',
            'coef' => 2.5,
        ]);
        $arr->push([
            'id' => 'none',
            'value' => 'Aucun',
            'coef' => 1,
        ]);

        if ($search != null) {
            return $arr->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $arr;
        }
    }

    /**
     * Retrieve the type of money shop based on search criteria.
     *
     * @param  string|null  $search  The ID of the type to search for.
     * @return mixed The value of the 'value' field for the specified ID if $search is provided, otherwise the collection of money shop types.
     */
    public function selectorMoneyShop(?string $search = null): mixed
    {
        $argc = collect();
        $argc->push([
            'id' => 'tpoint',
            'value' => 'T Point',
        ]);
        $argc->push([
            'id' => 'argent',
            'value' => 'Monnaie Virtuel',
        ]);
        $argc->push([
            'id' => 'euro',
            'value' => 'Monnaie Réel',
        ]);

        if ($search != null) {
            return $argc->where('id', $search)->first()['value'];
        } else {
            return $argc;
        }
    }

    /**
     * Select the type of motor.
     *
     * @param  string|null  $search  The search criteria.
     * @param  string|null  $field  The field to return.
     * @return \Illuminate\Support\Collection|string|null The collection of motor types or the specified field value.
     */
    public function selectorTypeMotor(?string $search = null, ?string $field = null): string|\Illuminate\Support\Collection|null
    {
        $argc = collect();

        $argc->push([
            'id' => 'diesel',
            'value' => 'Diesel',
            'coef' => 1.5,
        ]);

        $argc->push([
            'id' => 'electrique 1500v',
            'value' => 'Electrique 1500V',
            'coef' => 1.8,
        ]);

        $argc->push([
            'id' => 'electrique 25Kv',
            'value' => 'Electrique 25Kv',
            'coef' => 1.8,
        ]);

        $argc->push([
            'id' => 'electrique 1500v/25Kv',
            'value' => 'Electrique 1500V/25Kv',
            'coef' => 1.8,
        ]);

        $argc->push([
            'id' => 'vapeur',
            'value' => 'Vapeur',
            'coef' => 1.2,
        ]);

        $argc->push([
            'id' => 'hybride',
            'value' => 'Hybride',
            'coef' => 2.2,
        ]);

        $argc->push([
            'id' => 'autre',
            'value' => 'Autre',
            'coef' => 1,
        ]);

        if ($search != null) {
            return $argc->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $argc;
        }
    }

    /**
     * Retrieves a collection of selector type marchandise.
     *
     * @param  string|null  $search  The value to search for. Defaults to null.
     * @param  string|null  $field  The field to retrieve for the matching record. Defaults to null.
     * @return \Illuminate\Support\Collection|array|string Returns the collection of selector type marchandise if $search is null.
     *                                                     If $search is not null, returns the value of the specified $field for the matching record, or null if no match is found.
     */
    public function selectorTypeMarchandise(?string $search = null, ?string $field = null): array|string|\Illuminate\Support\Collection
    {
        $argc = collect();

        $argc->push([
            'id' => 'none',
            'value' => 'Aucun',
            'coef' => 1,
        ]);

        $argc->push([
            'id' => 'passagers',
            'value' => 'Passagers',
            'coef' => 1.5,
        ]);

        $argc->push([
            'id' => 'marchandises',
            'value' => 'Marchandises',
            'coef' => 1.2,
        ]);

        if ($search != null) {
            return $argc->where('id', $search)->first()[$field ?? 'value'];
        } else {
            return $argc;
        }
    }
}
