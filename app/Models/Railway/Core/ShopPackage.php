<?php

namespace App\Models\Railway\Core;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopPackage extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $guarded = [];
    protected $connection = 'mysql';

    public function category()
    {
        return $this->belongsTo(ShopCategory::class, 'shop_category_id');
    }

    public function items()
    {
        return $this->belongsToMany(ShopItem::class, 'package_items', 'package_id', 'item_id');
    }
}
