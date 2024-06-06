<?php

namespace App\Models\Support\Tickets;

use App\Models\Config\Service;
use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperTicketCategory
 */
class TicketCategory extends Model
{
    protected $guarded = [];

    protected $connection = 'mysql';

    public $timestamps = false;

    public function service()
    {
        return $this->belongsTo(Service::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }
}
