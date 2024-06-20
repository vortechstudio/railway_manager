<?php

namespace App\Models\User\Railway;

use App\Enums\Railway\Config\RailwayBanqueStatusEnum;
use App\Enums\Railway\Users\RailwayEmpruntTypeEnum;
use App\Models\Railway\Config\RailwayBanque;
use App\Services\Models\User\Railway\UserRailwayEmpruntAction;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserRailwayEmprunt extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'railway';

    protected $casts = [
        'date' => 'datetime',
        'type_emprunt' => RailwayEmpruntTypeEnum::class,
        'status' => RailwayBanqueStatusEnum::class,
    ];

    protected $appends = [
        'status_label',
    ];
    public function railwayBanque(): BelongsTo
    {
        return $this->belongsTo(RailwayBanque::class);
    }

    public function userRailway()
    {
        return $this->belongsTo(UserRailway::class);
    }

    public function userRailwayEmpruntTables()
    {
        return $this->hasMany(UserRailwayEmpruntTable::class);
    }

    public function getStatusLabelAttribute()
    {
        $color = (new UserRailwayEmpruntAction($this))->stylizingStatus('color');
        $text = (new UserRailwayEmpruntAction($this))->stylizingStatus('text');
        $icon = (new UserRailwayEmpruntAction($this))->stylizingStatus('icon');
        return "<span class='badge badge-{$color}'><i class='fa-solid {$icon} text-white me-2'></i> $text</span>";
    }
}
