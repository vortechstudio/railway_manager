<?php

namespace App\Models\Wiki;

use Illuminate\Database\Eloquent\Model;

class WikiSubCategory extends Model
{
    protected $guarded = [];

    protected $connection = 'mysql';

    public $timestamps = false;

    public function category()
    {
        return $this->belongsTo(WikiCategory::class);
    }

    public function articles()
    {
        return $this->hasMany(WikiSubCategory::class);
    }
}
