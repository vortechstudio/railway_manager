<?php

namespace App\Models\Railway\Config;

use Illuminate\Database\Eloquent\Model;

class RailwayFluxMarket extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'railway';

    protected $casts = [
        'date' => 'datetime',
    ];
}
