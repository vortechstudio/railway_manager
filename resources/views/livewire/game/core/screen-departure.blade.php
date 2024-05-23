<div class="card shadow-sm mb-10" wire:poll.visible.30s>
    <div class="card-header bg-blue-800 text-white">
        <h3 class="card-title">Prochains Départ</h3>
        <div class="card-toolbar">
        </div>
    </div>
    <div class="card-body bg-blue-700 p-0 m-0">
        @if(count($plannings) == 0)
            <x-base.is-null text="Aucun trajet programmé" />
        @else
            @foreach($plannings as $planning)
                <div class="d-flex align-items-center p-3 gap-5 bg-white shadow-lg mb-2">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <span class="fs-2 fw-bolder text-blue-800">{{ \Carbon\Carbon::parse($planning->date_depart)->format('H:i') }}</span>
                        @if($planning->status->value == 'initialized')
                        <div class="d-flex align-items-center rounded-3 border border-primary p-1">
                            <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                            <span class="fs-4 text-blue-800 fw-semibold"> à l'heure</span>
                        </div>
                        @elseif($planning->status->value == 'retarded')
                            <div class="d-flex align-items-center rounded-3 bg-orange-600 border border-orange-900 p-2">
                                <div class="animate__animated animate__flash animate__infinite">
                                    <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                    <span class="fs-4 text-blue-800 fw-semibold"> Retardé</span>
                                </div>
                            </div>
                        @elseif($planning->status->value == 'canceled')
                            <div class="d-flex align-items-center rounded-3 bg-red-600 border border-red-900 p-2">
                                <div class="">
                                    <i class="fa-solid fa-clock-four text-white me-2 fs-3"></i>
                                    <span class="fs-4 text-white fw-semibold"> Annulé</span>
                                </div>
                            </div>
                        @else
                            <div class="d-flex align-items-center rounded-3 border border-primary p-1">
                                <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                <span class="fs-4 text-blue-800 fw-semibold"> Départ Imminent</span>
                            </div>
                        @endif
                    </div>
                    <div class="d-flex flex-grow-1 justify-content-between align-items-center">
                        <div class="d-flex flex-column">
                            <span class="fs-2hx text-blue-800 fw-bold">{{ $planning->userRailwayLigne->railwayLigne->end->name }}</span>
                            <div class="d-flex align-items-center">
                                <span class="text-green-300 fs-3 me-2">via</span>
                                @foreach($planning->userRailwayLigne->railwayLigne->stations as $station)
                                    <span class="fs-2 text-blue-800">{{ $station->gare->name }}</span>
                                    <span class="bullet bullet-dot bg-green-300 mx-1"></span>
                                @endforeach
                            </div>
                        </div>
                    </div>
                    <div class="d-flex flex-grow-0 bg-green-300 align-items-center justify-content-center w-100px h-auto rounded-2 p-2">
                        <div class="d-flex flex-column align-items-center">
                            <span class="fs-3 text-blue-800">{{ $planning->userRailwayEngine->railwayEngine->type_transport->value }}</span>
                            <span class="fs-2 text-blue-800 fw-bold">{{ $planning->number_travel }}</span>
                        </div>
                    </div>
                </div>
            @endforeach
        @endif
    </div>
</div>
