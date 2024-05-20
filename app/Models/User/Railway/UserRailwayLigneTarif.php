<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Users\RailwayLigneTarifTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayLigneTarif extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'railway';

    protected $casts = [
        'date_tarif' => 'timestamp',
        'type_tarif' => RailwayLigneTarifTypeEnum::class,
    ];

    public function userRailwayLigne(): BelongsTo
    {
        return $this->belongsTo(UserRailwayLigne::class);
    }
}
