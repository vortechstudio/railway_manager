<?php

namespace App\Models\Social;

use App\Enums\Social\EventGraphicTypeEnum;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class EventGraphic extends Model
{
    protected $guarded = [];

    protected $casts = [
        'type_media' => EventGraphicTypeEnum::class,
    ];

    protected $appends = [
        'format_note',
    ];

    public function event(): BelongsTo
    {
        return $this->belongsTo(Event::class);
    }

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function getFormatNoteAttribute()
    {
        $badgeClass = ($this->notation <= 2.5) ? 'badge-danger' : (($this->notation <= 3.9) ? 'badge-warning' : 'badge-success');

        return "<span class='badge $badgeClass'>$this->notation</span>";
    }
}
