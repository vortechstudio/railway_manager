<?php

namespace App\Models\Config;

use Illuminate\Database\Eloquent\Model;

/**
 * @mixin IdeHelperServiceVersion
 */
class ServiceVersion extends Model
{
    protected $guarded = [];

    protected $connection = 'mysql';

    protected $casts = [
        'published_at' => 'timestamp',
        'publish_social_at' => 'timestamp',
    ];

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
