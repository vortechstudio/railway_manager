<div class="d-flex flex-column-fluid h-500px bg-blue-900">
    <div class="d-flex flex-row-fluid h-80 p-5 gap-15">
        <div class="card shadow-sm w-45 h-80 bg-gray-300">
            <div class="card-header justify-content-between align-items-center">
                <span class="fs-3x fw-bolder text-blue-800">{{ $planning->date_depart->format('H:i') }}</span>
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
            <div class="d-flex flex-row h-70px justify-content-end">
                <div class="p-5 border border-2 border-indigo-800 rounded-2 text-white">
                    <span id="clock-hours" class="fs-1">23</span>
                    <span class="animation-blink">
                            <span class="animation-blink-clock fs-1">:</span>
                        </span>
                    <span id="clock-minutes" class="fs-1">32</span>
                    <small id="clock-seconds" class="fs-3 ms-1 text-orange-600">37</small>
                </div>
            </div>
            <div class="d-flex flex-wrap w-100 ms-5">
                <div class="d-flex flex-column">
                    @foreach($planning->stations as $station)
                        <div class="d-flex flex-row justify-content-start align-items-center mb-3">
                            <span class="bullet bullet-dot {{ $station->name == $planning->userRailwayLigne->railwayLigne->start->name || $station->name == $planning->userRailwayLigne->railwayLigne->end->name ? 'w-30px h-30px' : 'w-15px h-15px' }} bg-blue-900 border border-3 border-blue-300 me-8"></span>
                            <span class="{{ $station->name == $planning->userRailwayLigne->railwayLigne->start->name || $station->name == $planning->userRailwayLigne->railwayLigne->end->name ? 'fs-2x' : 'fs-2' }} fw-bold text-white">{{ $station->name }}</span>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>

    </div>
</div>
