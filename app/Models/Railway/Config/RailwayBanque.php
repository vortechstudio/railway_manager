<?php

namespace App\Models\Railway\Config;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class RailwayBanque extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'uuid' => 'string',
    ];

    public function fluxes()
    {
        return $this->hasMany(RailwayBanqueFlux::class);
    }
}
