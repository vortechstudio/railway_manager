<?php

namespace App\Models\Railway\Gare;

use Illuminate\Database\Eloquent\Model;

class RailwayGareWeather extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $casts = [
        'latest_update' => 'datetime',
    ];

    public function gare()
    {
        return $this->belongsTo(RailwayGare::class, 'gare_id');
    }
}
