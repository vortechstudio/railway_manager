<?php

namespace App\Models\User;

use Illuminate\Database\Eloquent\Model;

class ResearchUser extends Model
{
    protected $guarded = [];

    protected $connection = 'railway';

    protected $table = 'research_user';

    protected $appends = [
        'is_unlocked_format',
    ];

    public function getIsUnlockedFormatAttribute()
    {
        if ($this->is_unlocked) {
            return '<i class="fa-solid fa-check-circle text-success fs-2"></i>';
        } else {
            return '<i class="fa-solid fa-xmark-circle text-danger fs-2"></i>';
        }
    }
}
