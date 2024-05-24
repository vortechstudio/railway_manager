<div wire:poll.keep-alive.30s>
    @if($planning->status->value == 'initialized' || $planning->status->value == 'departure' || $planning->status->value == 'retarded' || $planning->status->value == 'canceled')
        @if($planning->date_depart >= now() && $planning->date_depart <= now()->addMinutes())
            @livewire('game.core.screen.ecran-departure-alerte')
        @else
            @livewire('game.core.screen.ecran-departure-single', ["planning" => $planning])
        @endif
    @elseif($planning->status->value == 'travel' || $planning->status->value == 'in_station')
        @livewire('game.core.screen.ecran-sive-travel', ["planning" => $planning])
    @else
        @livewire('game.core.screen.ecran-sive-arrival', ["planning" => $planning])
    @endif
</div>
