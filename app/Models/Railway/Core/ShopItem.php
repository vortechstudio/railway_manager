<?php

namespace App\Models\Railway\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopItem extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    public function shopCategory(): BelongsTo
    {
        return $this->belongsTo(ShopCategory::class);
    }

    public function packages()
    {
        return $this->belongsToMany(ShopPackage::class);
    }
}
