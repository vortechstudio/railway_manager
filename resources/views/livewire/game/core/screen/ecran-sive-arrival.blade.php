@if($planning->userRailwayLigne->railwayLigne->type->value == 'ter')
    <div class="d-flex flex-column bg-white rounded-3 shadow-lg h-600px">
        <div
            class="d-flex flex-row justify-content-between align-items-center bg-indigo-900 h-100px overflow-hidden fs-2x fw-bold text-white px-5">
            <div class="d-flex">
                <img src="{{ $planning->userRailwayLigne->railwayLigne->icon }}" class="w-70px me-5" alt="">
                <span>{{ $planning->userRailwayLigne->railwayLigne->type->name }} {{ $planning->number_travel }}</span>
            </div>
            <div class="d-flex align-items-center me-20">
                <i class="fa-solid fa-gauge-high text-white fs-3x me-3"></i> <span
                    class="speedometer"> 0 Km/H</span>
            </div>
        </div>
        <div class="d-flex flex-row-fluid align-items-center h-100">
            <div class="d-flex flex-column justify-content-center align-items-center w-70">
                <div class="fs-3hx text-color-ter fw-bolder"><?= $planning->userRailwayLigne->railwayLigne->end->name ?></div>
                <div class="fs-5x text-gray-400 fw-bold">Terminus</div>
            </div>
        </div>
        <div class="d-flex align-items-middle bg-gray-700 h-80px overflow-hidden">
            <div class="d-flex flex-row justify-content-between align-items-center mx-5">
                <div>
                    <span id="clock-hours" class="fs-2x text-grey-500 fw-semibold">{{ now()->format('H') }}</span>
                    <span class="animation-blink">
                                <span class="animation-blink-clock fs-2x text-grey-500 fw-semibold">:</span>
                            </span>
                    <span id="clock-minutes" class="fs-2x text-grey-500 fw-semibold">{{ now()->format('i') }}</span>
                    <small id="clock-seconds" class="fs-3 ms-1 text-color-ter ">{{ now()->format('s') }}</small>
                </div>
            </div>
        </div>
    </div>
@endif
@if($planning->userRailwayLigne->railwayLigne->type->value == 'tgv')
    <div class="d-flex flex-column bg-color-tgv rounded-3 shadow-lg h-600px">
        <div class="d-flex align-items-center h-130px bg-white">
            <div class="d-flex flex-column w-25">
                <div class="d-flex flex-row justify-content-between align-items-center">
                    <img src="{{ $planning->userRailwayLigne->railwayLigne->icon }}" class="ps-5 w-100px" alt="">
                    <div class="d-flex flex-column justify-content-center align-items-center">
                        <iconify-icon icon="mdi:train-car-passenger-variant" class="text-gray-400" width="70" height="70"></iconify-icon>
                        <span class="fs-3x fw-bold text-gray-400">{{ rand(1, $planning->userRailwayEngine->railwayEngine->technical->nb_wagon) }}</span>
                    </div>
                </div>
                <div class="ps-5">
                    <span id="clock-hours" class="fs-3x text-black fw-semibold">23</span>
                    <span class="animation-blink">
                                <span class="animation-blink-clock fs-2x black fw-semibold">:</span>
                            </span>
                    <span id="clock-minutes" class="fs-3x text-black fw-semibold">32</span>
                    <small id="clock-seconds" class="fs-3 ms-1 text-color-tgv ">37</small>
                </div>
            </div>
            <div class="flex-grow-1" wire:poll.15s>
                <div class="d-flex flex-column justify-content-center align-items-center">
                    <div class="fw-bolder text-color-tgv fs-3x"><?= $planning->userRailwayLigne->railwayLigne->end->name ?></div>
                    <div class="fw-bolder text-gray-400 fs-2x">Terminus</div>
                    <div class="fw-bolder text-gray-500 fs-3x">Train en correspondance</div>
                </div>
            </div>
        </div>
        <div class="d-flex flex-column align-items-center">
            <table class="table table-striped table-dark gs-5 gs-5 gy-5 p-0 m-0">
                <thead>
                <tr class="fs-2x fw-semibold">
                    <th>Départ</th>
                    <th></th>
                    <th>Train</th>
                    <th>Destination</th>
                    <th>Voie</th>
                </tr>
                </thead>
                <tbody>
                <tr class="fw-bolder fs-1">
                    <td class="w-100px">18:00</td>
                    <td>TGV</td>
                    <td>8 360</td>
                    <td>Marseille Saint-Charles</td>
                    <td>4</td>
                </tr>
                <tr class="fw-bolder fs-1">
                    <td class="w-100px">18:00</td>
                    <td>TGV</td>
                    <td>8 360</td>
                    <td>Marseille Saint-Charles</td>
                    <td>4</td>
                </tr>
                </tbody>
            </table>
        </div>
    </div>
@endif
