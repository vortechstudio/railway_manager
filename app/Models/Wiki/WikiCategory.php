<?php

namespace App\Models\Wiki;

use App\Models\Social\Cercle;
use Illuminate\Database\Eloquent\Model;

class WikiCategory extends Model
{
    protected $guarded = [];

    protected $connection = 'mysql';

    public $timestamps = false;

    public function cercle()
    {
        return $this->belongsTo(Cercle::class);
    }

    public function subcategories()
    {
        return $this->hasMany(WikiSubCategory::class);
    }

    public function articles()
    {
        return $this->hasMany(Wiki::class);
    }
}
