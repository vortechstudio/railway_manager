<?php

namespace App\Models\Support\Tickets;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

class TicketMessage extends Model
{
    protected $guarded = [];
    protected $connection = 'mysql';

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}
