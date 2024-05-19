<?php

namespace App\Models\Config;

use App\Models\Railway\Core\ShopCategory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Shop extends Model
{
    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'mysql';

    public function service(): BelongsTo
    {
        return $this->belongsTo(Service::class, 'service_id');
    }

    public function railway_categories()
    {
        return $this->hasMany(ShopCategory::class);
    }
}
