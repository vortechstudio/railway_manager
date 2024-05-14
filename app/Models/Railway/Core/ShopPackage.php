<?php

namespace App\Models\Railway\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopPackage extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $guarded = [];

    public function category()
    {
        return $this->belongsTo(ShopCategory::class, 'shop_category_id');
    }

    public function items()
    {
        return $this->belongsToMany(ShopItem::class);
    }
}
