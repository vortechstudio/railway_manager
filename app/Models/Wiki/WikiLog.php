<?php

namespace App\Models\Wiki;

use Illuminate\Database\Eloquent\Model;

class WikiLog extends Model
{
    protected $guarded = [];

    public function article()
    {
        return $this->belongsTo(Wiki::class);
    }
}
