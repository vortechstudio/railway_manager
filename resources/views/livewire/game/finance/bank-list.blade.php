<div>
    <div class="card shadow-sm">
        <div class="card-body">
            @if(count($banques) > 0)
                @foreach($banques as $banque)
                    @livewire('game.finance.bank-card', ['banque' => $banque])
                @endforeach
            @else
                <x-base.is-null text="Aucune banque disponible actuellement" />
            @endif
        </div>
    </div>
</div>
