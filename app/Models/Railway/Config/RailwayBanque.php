<?php

namespace App\Models\Railway\Config;

use App\Enums\Railway\Config\RailwayBanqueBlockedEnum;
use App\Models\User\Railway\UserRailwayCompany;
use App\Models\User\Railway\UserRailwayEmprunt;
use App\Models\User\ResearchUser;
use App\Services\Models\User\Railway\UserRailwayAction;
use App\Services\Models\User\Railway\UserRailwayCompanyAction;
use Cache;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Storage;
use Str;

class RailwayBanque extends Model
{
    use SoftDeletes;

    protected $guarded = [];

    protected $connection = 'railway';

    public $timestamps = false;

    protected $casts = [
        'uuid' => 'string',
        'blocked_by' => RailwayBanqueBlockedEnum::class,
    ];

    protected $appends = [
        'image',
        'latest_flux',
        'is_unlocked',
        'is_unlocked_text',
        'interest_percentage'
    ];

    public function fluxes()
    {
        return $this->hasMany(RailwayBanqueFlux::class);
    }

    public function userRailwayEmprunts()
    {
        return $this->hasMany(UserRailwayEmprunt::class);
    }

    public function getImageAttribute()
    {
        return Cache::remember('getImageAttribute:'.$this->name, 1440, function () {
            return Storage::exists('logos/banks/'.Str::lower($this->name).'.webp') ? Storage::url('logos/banks/'.Str::lower($this->name).'.webp') : Storage::url('logos/banks/default.png');
        });
    }

    public function getLatestFluxAttribute()
    {
        return $this->fluxes()->orderBy('date', 'desc')->first()->interest;
    }

    public function getIsUnlockedAttribute()
    {
        if($this->blocked_by != null) {
            return match ($this->blocked_by->value) {
                "level" => auth()->user()->railway->level >= $this->blocked_by_id,
                "research" => ResearchUser::where('railway_research_id', $this->blocked_by_id)->where('user_railway_id', auth()->user()->railway->id)->where('is_unlocked', true)->exists(),
                "ca" => (new UserRailwayCompanyAction(auth()->user()->railway_company))->getCA() >= $this->blocked_by_id,
                default => null,
            };
        } else {
            return true;
        }
    }

    public function getIsUnlockedTextAttribute()
    {
        if($this->blocked_by) {
            return match ($this->blocked_by->value) {
                "level" => "Votre niveau est insuffisant (Level {$this->blocked_by_id})",
                "research" => "Vous ne pouvez pas encore accéder à cette banque. Vous devez la débloquer avec la R&D",
                "ca" => "Votre Chiffre d'affaire n'à pas atteint {$this->blocked_by_id} €",
                default => null,
            };
        } else {
            return null;
        }
    }

    public function getInterestPercentageAttribute()
    {
        return ($this->interest_min * $this->latest_flux / $this->interest_max) * 100;
    }

    /**
     * Generate a new flux record.
     */
    public function generate(): void
    {
        $this->fluxes()->create([
            'date' => now()->startOfDay(),
            'interest' => random_float($this->interest_min, $this->interest_max),
            'railway_banque_id' => $this->id,
        ]);
    }
}
