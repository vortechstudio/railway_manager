<?php

namespace App\Models\Support\Tickets;

use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTicketMessage
 */
class TicketMessage extends Model
{
    protected $guarded = [];

    protected $connection = 'mysql';

    protected $casts = [
        'read_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function ticket()
    {
        return $this->belongsTo(Ticket::class, 'ticket_id');
    }
}
