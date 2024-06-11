<?php

namespace App\Services\Models\User\Railway;

use App\Models\User\Railway\UserRailwayEngineTechnicentre;
use App\Notifications\SendMessageAdminNotification;

class UserRailwayEngineTechnicentreAction
{
    public function __construct(private UserRailwayEngineTechnicentre $engineTechnicentre)
    {
    }

    public function delivered()
    {
        match ($this->engineTechnicentre->type) {
            'engine_prev' => $this->deliveredEnginePrev(),
            'engine_cur' => $this->deliveredEngineCur(),
        };
    }

    public function getTypeStyle(string $style): string
    {
        return match ($this->engineTechnicentre->type->value) {
            'engine_prev' => match ($style) {
                'text' => 'Maintenance Préventive',
                'color' => 'blue-500',
                'icon' => 'fa-calendar'
            },
            'engine_cur' => match ($style) {
                'text' => 'Maintenance Curative',
                'color' => 'red-500',
                'icon' => 'fa-cogs'
            },
        };
    }

    private function deliveredEnginePrev()
    {
        $this->engineTechnicentre->userRailwayEngine->update([
            'use_percent' => 0,
        ]);

        $this->engineTechnicentre->user->notify(new SendMessageAdminNotification(
            title: 'Maintenance Préventive terminer',
            sector: 'alert',
            type: 'info',
            message: "La Maintenance Préventive pour la rame {$this->engineTechnicentre->userRailwayEngine->number} / {$this->engineTechnicentre->userRailwayEngine->railwayEngine->name} est terminer"
        ));

        $this->engineTechnicentre->delete();
    }
}
