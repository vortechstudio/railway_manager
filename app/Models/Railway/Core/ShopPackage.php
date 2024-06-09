<?php

namespace App\Models\Railway\Core;

use App\Enums\Config\Shop\ShopItemCurrencyTypeEnum;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopPackage extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'mysql';

    protected $casts = [
        'currency_type' => ShopItemCurrencyTypeEnum::class,
    ];

    public function category()
    {
        return $this->belongsTo(ShopCategory::class, 'shop_category_id');
    }

    public function items()
    {
        return $this->belongsToMany(ShopItem::class, 'package_item', 'shop_package_id', 'shop_item_id');
    }
}
