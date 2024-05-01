<?php

namespace App\Models\Railway\Ligne;

use App\Models\Railway\Gare\RailwayGare;
use Illuminate\Database\Eloquent\Model;

class RailwayLigneStation extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    public function gare()
    {
        return $this->belongsTo(RailwayGare::class, 'gare_id');
    }

    public function ligne()
    {
        return $this->belongsTo(RailwayLigne::class, 'ligne_id');
    }
}
