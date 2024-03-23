<?php

namespace App\Models\Wiki;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pharaonic\Laravel\Pages\HasPages;

class Wiki extends Model
{
    use HasPages, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'posted_at' => 'timestamp',
    ];

    public function category()
    {
        return $this->belongsTo(WikiCategory::class);
    }

    public function subcategory()
    {
        return $this->belongsTo(WikiSubCategory::class);
    }

    public function logs()
    {
        return $this->hasMany(WikiLog::class);
    }
}
