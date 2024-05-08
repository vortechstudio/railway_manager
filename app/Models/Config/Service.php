<?php

namespace App\Models\Config;

use App\Enums\Config\ServiceStatusEnum;
use App\Enums\Config\ServiceTypeEnum;
use App\Models\Social\Cercle;
use App\Models\Support\Tickets\Ticket;
use App\Models\Support\Tickets\TicketCategory;
use App\Models\User\User;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\SoftDeletes;
use Pharaonic\Laravel\Pages\HasPages;

class Service extends Model
{
    use HasPages, SoftDeletes;

    protected $guarded = [];

    protected $casts = [
        'type' => ServiceTypeEnum::class,
        'status' => ServiceStatusEnum::class,
    ];

    protected $appends = [
        'type_label',
        'status_label',
        'latest_version',
        'other_versions',
    ];

    public function users()
    {
        return $this->hasMany(User::class);
    }

    public function versions(): HasMany
    {
        return $this->hasMany(ServiceVersion::class);
    }

    public function ticket_categories()
    {
        return $this->hasMany(TicketCategory::class);
    }

    public function tickets()
    {
        return $this->hasMany(Ticket::class);
    }

    public function cercle()
    {
        return $this->belongsTo(Cercle::class);
    }

    public function getTypeLabelAttribute()
    {
        return match ($this->type) {
            ServiceTypeEnum::PLATEFORME => '<span class="badge badge-primary"><i class="fa-solid fa-cubes text-white me-2"></i> Plateforme</span>',
            ServiceTypeEnum::JEUX => '<span class="badge badge-warning"><i class="fa-solid fa-gamepad text-white me-2"></i> Jeux</span>',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            ServiceStatusEnum::IDEA => '<span class="badge badge-warning"><i class="fa-solid fa-lightbulb text-white me-2"></i> Idée</span>',
            ServiceStatusEnum::DEVELOP => '<span class="badge badge-primary"><i class="fa-solid fa-code text-white me-2"></i> Développement</span>',
            ServiceStatusEnum::PRODUCTION => '<span class="badge badge-success"><i class="fa-solid fa-boxes-stacked text-white me-2"></i> Production</span>',
        };
    }

    public function getLatestVersionAttribute()
    {
        return $this->versions()->where('published', true)->orderBy('version', 'desc')->first();
    }

    public function getOtherVersionsAttribute()
    {
        return $this->versions()->where('published', true)->whereNot('version', $this->latest_version->version)->orderBy('version', 'desc')->get();
    }

    public static function getImage(int $service_id, string $type): string
    {
        $type = match ($type) {
            'icon' => 'icon',
            'header' => 'header',
            'default' => 'default',
        };

        if (\Storage::exists('services/'.$service_id.'/'.$type.'.webp')) {
            return \Storage::url('services/'.$service_id.'/'.$type.'.webp');
        } else {
            return \Storage::url('services/'.$type.'_default.png');
        }
    }
}
