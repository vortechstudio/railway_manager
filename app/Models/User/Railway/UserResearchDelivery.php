<?php

namespace App\Models\User\Railway;

use App\Models\User\ResearchUser;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserResearchDelivery extends Model
{
    protected $guarded = [];

    public $timestamps = false;

    protected $connection = 'railway';

    protected $casts = [
        'start_at' => 'datetime',
        'end_at' => 'datetime',
    ];

    protected $appends = [
        'diff_in_second',
    ];

    public function researchUser(): BelongsTo
    {
        return $this->belongsTo(ResearchUser::class);
    }

    public function userRailway()
    {
        return $this->belongsTo(UserRailway::class, 'user_railway_id');
    }

    public function getDiffInSecondAttribute()
    {
        return $this->end_at->diffInSeconds($this->start_at);
    }
}
