<div class="d-flex flex-column h-500px bg-blue-900">
    <div class="d-flex flex-row-fluid h-80 p-5 gap-15">
        <div class="card shadow-sm w-45 h-80 bg-gray-300">
            <div class="card-header justify-content-between align-items-center">
                <span class="fs-3x fw-bolder {{ $planning->status->value == 'retarded' ? 'text-orange-800 strike' : ($planning->status->value == 'canceled' ? 'text-red-800 strike' : 'text-blue-800') }}">{{ $planning->date_depart->format('H:i') }}</span>
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
            <div class="card-body bg-light flex-column">
                <span class="fw-bolder fs-2x text-blue-800">{{ $planning->userRailwayLigne->railwayLigne->end->name }}</span>
                <div class="d-flex flex-row p-5 bg-blue-300 w-75 rounded">
                    <span class="fw-bold fs-1 text-blue-800">TER 853301</span>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column w-100 ">
            <div class="d-flex flex-row h-70px justify-content-end" wire:poll.keep-alive.1s>
                <div class="p-5 border border-2 border-indigo-800 rounded-2 text-white">
                    <span id="clock-hours" class="fs-1">{{ now()->format('H') }}</span>
                    <span class="animation-blink">
                            <span class="animation-blink-clock fs-1">:</span>
                        </span>
                    <span id="clock-minutes" class="fs-1">{{ now()->format('i') }}</span>
                    <small id="clock-seconds" class="fs-3 ms-1 text-orange-600">{{ now()->format('s') }}</small>
                </div>
            </div>
            <div class="d-flex flex-wrap w-100 ms-5">
                <div class="d-flex flex-column">
                    <table class="table align-middle gap-5 gy-2 gs-2 gx-2">
                        <tbody>
                            @foreach($planning->stations as $station)
                            <tr>
                                <td><span class="text-white me-5 {{ $station->name == $planning->userRailwayLigne->railwayLigne->start->name || $station->name == $planning->userRailwayLigne->railwayLigne->end->name ? 'fs-2x' : 'fs-2' }}">{{ $station->departure_at->format('H:i') }}</span></td>
                                <td><span class="bullet bullet-dot {{ $station->name == $planning->userRailwayLigne->railwayLigne->start->name || $station->name == $planning->userRailwayLigne->railwayLigne->end->name ? 'w-20px h-20px border-4' : 'border-2' }} w-15px h-15px bg-blue-900 border border-blue-300 me-8"></span></td>
                                <td><span class="{{ $station->name == $planning->userRailwayLigne->railwayLigne->start->name || $station->name == $planning->userRailwayLigne->railwayLigne->end->name ? 'fs-2x' : 'fs-2' }} fw-bold text-white">{{ $station->name }}</span></td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    @if($planning->status->value == 'retarded')
        <div class="d-flex h-5 bg-orange-400 bg-striped"></div>
        <div class="d-flex h-10 p-3 bg-orange-600">
            <span class="text-white fs-1 fw-bold">{{ $planning->incidents()->first()->designation }} (retard estimé: {{ $planning->retarded_time }} min)</span>
        </div>
    @elseif($planning->status->value == 'canceled')
        <div class="d-flex h-5 bg-red-400 bg-striped"></div>
        <div class="d-flex h-10 p-3 bg-red-600">
            <span class="text-white fs-1 fw-bold">{{ $planning->incidents()->first()->designation }}</span>
        </div>
    @endif

</div>
