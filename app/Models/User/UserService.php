<?php

namespace App\Models\User;

use App\Models\Config\Service;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class UserService extends Model
{
    use SoftDeletes;

    public $timestamps = false;
    protected $connection = 'mysql';
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function service()
    {
        return $this->belongsTo(Service::class, 'service_id');
    }
}
