<?php

namespace App\Models\Railway\Core;

use App\Models\Config\Shop;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;

class ShopCategory extends Model
{
    use SoftDeletes;

    public $timestamps = false;

    protected $guarded = [];

    protected $connection = 'mysql';

    protected $appends = [
        'image',
    ];

    public function shop(): BelongsTo
    {
        return $this->belongsTo(Shop::class, 'shop_id');
    }

    public function railway_items()
    {
        return $this->hasMany(ShopItem::class);
    }

    public function railway_packages()
    {
        return $this->hasMany(ShopPackage::class);
    }

    public function getImage()
    {
        if (empty($this->icon)) {
            return \Storage::url('icons/railway/shop/category/'.\Str::slug($this->name).'.png');
        } else {
            return $this->icon;
        }
    }

    public function getImageAttribute()
    {
        return $this->getImage();
    }
}
