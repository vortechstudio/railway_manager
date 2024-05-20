<?php

namespace App\Models\Railway\Ligne;

use App\Models\Railway\Gare\RailwayGare;
use App\Models\Railway\Planning\RailwayPlanningStation;
use Illuminate\Database\Eloquent\Model;

class RailwayLigneStation extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    public $timestamps = false;

    public function gare()
    {
        return $this->belongsTo(RailwayGare::class, 'railway_gare_id');
    }

    public function ligne()
    {
        return $this->belongsTo(RailwayLigne::class, 'railway_ligne_id');
    }

    public function planning_stations()
    {
        return $this->hasMany(RailwayPlanningStation::class);
    }
}
