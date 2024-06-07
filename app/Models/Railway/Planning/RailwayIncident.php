<?php

namespace App\Models\Railway\Planning;

use App\Enums\Railway\Core\IncidentTypeEnum;
use App\Models\User\Railway\UserRailwayEngine;
use App\Models\User\Railway\UserRailwayHub;
use App\Models\User\User;
use App\Services\RailwayService;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Support\Facades\Storage;

class RailwayIncident extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    protected $casts = [
        'type_incident' => IncidentTypeEnum::class,
    ];

    protected $appends = [
        'image_type',
        'niveau_indicator',
        'incidence',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function railwayPlanning(): BelongsTo
    {
        return $this->belongsTo(RailwayPlanning::class, 'railway_planning_id');
    }

    public function userRailwayEngine(): BelongsTo
    {
        return $this->belongsTo(UserRailwayEngine::class, 'user_railway_engine_id');
    }

    public function userRailwayHub(): BelongsTo
    {
        return $this->belongsTo(UserRailwayHub::class, 'user_railway_hub_id');
    }

    public function getImageTypeAttribute()
    {
        $service = (new RailwayService())->getRailwayService();

        return match ($this->type_incident->value) {
            'humain' => Storage::url('services/'.$service->id.'/game/incidents/humain.jpg'),
            'infrastructure' => Storage::url('services/'.$service->id.'/game/incidents/infrastructure.jpg'),
            'materiel' => Storage::url('services/'.$service->id.'/game/incidents/materiel.webp'),
        };
    }

    public function getNiveauIndicatorAttribute()
    {
        return match ($this->niveau) {
            1 => 'low',
            2 => 'medium',
            3 => 'high'
        };
    }

    public function getIncidenceAttribute()
    {
        return match ($this->niveau) {
            1 => 'Aucune incidence sur le trafic',
            2 => "{$this->railwayPlanning->retarded_time} min de retard sur le trajet",
            3 => 'Service supprimé'
        };
    }
}
