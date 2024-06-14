<?php

namespace App\Models;

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

    public function researchUser(): BelongsTo
    {
        return $this->belongsTo(ResearchUser::class);
    }
}
