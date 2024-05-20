<?php

namespace App\Models\Railway\Gare;

use Illuminate\Database\Eloquent\Model;

class RailwayGareWeather extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    public $timestamps = false;

    protected $casts = [
        'latest_update' => 'datetime',
    ];

    public function gare()
    {
        return $this->belongsTo(RailwayGare::class, 'railway_gare_id');
    }
}
