<?php

namespace App\Models\Railway\Config;

use Illuminate\Database\Eloquent\Model;

class RailwayBanqueFlux extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'date' => 'datetime',
    ];

    public function banque()
    {
        return $this->belongsTo(RailwayBanque::class, 'railway_banque_id');
    }
}
