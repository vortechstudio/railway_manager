<div>
    @if($planning->status->value == 'travel')
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
                    <div class="d-flex flex-column justify-content-center w-30 bg-gray-400 h-100 py-auto">
                        <div class="d-flex flex-column mb-5 mx-10">
                            <span class="fs-3 text-color-ter">Destination</span>
                            <div
                                class="fs-2x fw-bold text-gray-800"><?= $planning->userRailwayLigne->railwayLigne->end->name ?></div>
                        </div>
                        <div class="d-flex flex-column mb-5 mx-10">
                            <span class="fs-3 text-color-ter">Prochain arrets</span>
                            <div
                                class="fs-2x fw-bold text-gray-800"><?= $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first()->name ?></div>
                        </div>
                        <div class="d-flex flex-column mb-5 mx-10">
                            <span class="fs-3 text-color-ter">Arrivée prévue</span>
                            <div
                                class="fs-3x fw-bold text-gray-800"><?= $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first()->arrival_at->format("H:i") ?></div>
                        </div>
                    </div>
                    <div class="d-flex bg-white w-100 py-auto">
                        <div id="kt_carousel_1_carousel" class="carousel carousel-custom slide w-100 h-100"
                             data-bs-ride="carousel" data-bs-interval="5000">
                            <div class="carousel-inner">
                                <div class="carousel-item">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div
                                            class="w-25 d-flex flex-column justify-content-center align-items-center mb-3 ms-2">
                                            <div
                                                class="w-100px h-100px rounded-circle border border-2 border-color-ter d-flex justify-content-center align-items-center">
                                                <img src="{{ Storage::url('icons/railway/station.png') }}"
                                                     class="w-70px" alt="">
                                            </div>
                                            <span
                                                class="border border-2 border-color-ter rounded-5 fs-3 fw-semibold text-center mt-3 p-2">
                                            {{ $planning->stations()->where('status', 'done')->orderBy('departure_at', 'desc')->first()->name }}
                                        </span>
                                            <div
                                                class="fw-bolder fs-2"><?= $planning->stations()->where('status', 'done')->orderBy('departure_at', 'desc')->first()->departure_at->format("H:i") ?></div>
                                        </div>
                                        <div class="h-20px mx-3 w-50 bg-gray-400 bg-opacity-50 rounded mb-10">
                                            <div
                                                class="bg-color-ter rounded h-20px progress-bar-striped progress-bar-animated"
                                                role="progressbar"
                                                style="width: <?= $this->calcPercentTimeInPercent($planning->stations()->where('status', 'done')->orderBy('departure_at', 'desc')->first()->departure_at, $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first()->arrival_at) ?>%;"
                                                aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                                <div class="position-relative">
                                                    <img src="{{ Storage::url('icons/railway/train_point.png') }}"
                                                         alt="" class="w-45px translate-middle"
                                                         style="position: absolute; top: -25px; left: 100%">
                                                </div>
                                            </div>
                                        </div>
                                        <div
                                            class="w-25 d-flex flex-column justify-content-center align-items-center mb-3 animate__animated animate__flash animate__slower animate__infinite">
                                            <div
                                                class="w-100px h-100px rounded-circle border border-2 border-dotted border-color-ter d-flex justify-content-center align-items-center">
                                                <img src="{{ Storage::url('icons/railway/station_end.png') }}"
                                                     class="w-70px" alt="">
                                            </div>
                                            <span
                                                class="border border-2 border-dotted border-color-ter rounded-5 fs-3 fw-semibold text-center mt-3 p-2">
                                            {{ $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first()->name }}
                                        </span>
                                            <div
                                                class="fw-bolder fs-2">{{ $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first()->arrival_at->format("H:i") }}</div>
                                        </div>
                                    </div>
                                </div>
                                <div class="carousel-item active">
                                    <div class="d-flex justify-content-center align-items-center">
                                        <div id="mapStation" style="width: 100%; height: 500px;"></div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            @push("styles")
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
                      crossorigin=""/>
                <link rel="stylesheet"
                      href="{{ asset('/plugins/custom/leaflet-routing-machine/dist/leaflet-routing-machine.css') }}">
            @endpush
            @push('scripts')
                @php
                    $station_start = $planning->stations()->where('status', 'done')->orderBy('departure_at', 'desc')->first();
                    $station_end = $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first();

                    $centerLat = ($station_start->railwayLigneStation->gare->latitude + $station_end->railwayLigneStation->gare->latitude) / 2;
                    $centerLng = ($station_start->railwayLigneStation->gare->longitude + $station_end->railwayLigneStation->gare->longitude) / 2;
                @endphp
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                        crossorigin=""></script>
                <script src="{{ asset('/plugins/custom/leaflet-routing-machine/dist/leaflet-routing-machine.js') }}"></script>
                <script src="{{ asset('/plugins/custom/leaflet-moving-marker/MovingMarker.js') }}"></script>
                <script type="text/javascript">

                    let mapStation = L.map('mapStation').setView([{{ $centerLat }}, {{ $centerLng }}], 12);
                    let iconStationStart = L.icon({
                        iconUrl: '{{ Storage::url('icons/railway/station.png') }}',
                        iconSize: [30, 30],
                    });
                    let iconStationEnd = L.icon({
                        iconUrl: '{{ Storage::url('icons/railway/station_end.png') }}',
                        iconSize: [30, 30],
                    });
                    let iconTrain = L.icon({
                        iconUrl: '{{ Storage::url('icons/railway/train_point.png') }}',
                        iconSize: [45, 45],
                    })

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(mapStation);

                    let markerStationStart = L.marker([{{ $station_start->railwayLigneStation->gare->latitude }}, {{ $station_start->railwayLigneStation->gare->longitude }}], {icon: iconStationStart}).addTo(mapStation)
                    let markerStationEnd = L.marker([{{ $station_end->railwayLigneStation->gare->latitude }}, {{ $station_end->railwayLigneStation->gare->longitude }}], {icon: iconStationEnd}).addTo(mapStation)

                    mapStation.fitBounds([
                        markerStationStart.getLatLng(),
                        markerStationEnd.getLatLng()
                    ]);

                    let PolylineCoords = [
                        [{{ $station_start->railwayLigneStation->gare->latitude }}, {{ $station_start->railwayLigneStation->gare->longitude }}],
                        [{{ $station_end->railwayLigneStation->gare->latitude }}, {{ $station_end->railwayLigneStation->gare->longitude }}],
                    ];

                    let polylineStation = L.polyline(PolylineCoords, {color: 'red'}).addTo(mapStation)

                    let departureTime = new Date();
                    departureTime.setHours({{ $station_start->departure_at->format('H') }});
                    departureTime.setMinutes({{ $station_start->departure_at->format('i') }});

                    let arrivalTime = new Date();
                    arrivalTime.setHours({{ $station_end->arrival_at->format('H') }});
                    arrivalTime.setMinutes({{ $station_end->arrival_at->format('i') }});

                    let start = {
                        time: departureTime.getTime(),
                        lat: Number({{ $station_start->railwayLigneStation->gare->latitude }}),
                        lng: Number({{ $station_start->railwayLigneStation->gare->longitude }})
                    }

                    let end = {
                        time: arrivalTime.getTime(),  // Convertir les horaires de chaînes de caractères à des objets de Date
                        lat: Number({{ $station_end->railwayLigneStation->gare->latitude }}),
                        lng: Number({{ $station_end->railwayLigneStation->gare->longitude }})
                    }

                    let markerTrain = L.Marker.movingMarker([start, end], end.time - start.time, {icon: iconTrain}).addTo(mapStation)
                    mapStation.addLayer(markerTrain)

                    function interpolate(time, start, end) {
                        const latDiff = end.lat - start.lat;
                        const lngDiff = end.lng - start.lng;
                        const timeDiff = end.time - start.time;

                        const fractTime = (time - start.time) / timeDiff;

                        const newLat = start.lat + latDiff * fractTime;
                        const newLng = start.lng + lngDiff * fractTime;

                        return [newLat, newLng];
                    }

                    function updateTrainMarker() {
                        const now = new Date().getTime();

                        if(now > end.time || now < start.time) {
                            return;
                        }

                        const newLatLng = interpolate(now, start, end)
                        markerTrain.setLatLng(newLatLng);

                        setTimeout(updateTrainMarker, 15000)
                    }

                    function updateTime() {
                        const now = new Date();
                        const hours = now.getHours().toString().padStart(2, '0');
                        const minutes = now.getMinutes().toString().padStart(2, '0');
                        const seconds = now.getSeconds().toString().padStart(2, '0');

                        // Update UI elements with actual date/time
                        document.getElementById('clock-hours').textContent = hours;
                        document.getElementById('clock-minutes').textContent = minutes;
                        document.getElementById('clock-seconds').textContent = seconds;
                    }


                    updateTrainMarker()
                    updateTime()
                    setInterval(updateTime, 1000);
                </script>
            @endpush
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
                    <div class="d-flex align-items-center w-100">
                        <div class="separator border border-5 border-dotted border-color-tgv w-25"></div>
                        <div class="d-flex flex-column align-items-start justify-content-center position-relative">
                            <span class="fs-2 fw-bold text-color-tgv position-absolute w-200px m-5" style="top: 26px;right: -94px;"><?= $planning->stations()->where('status', 'done')->orderBy('departure_at', 'desc')->first()->name ?></span>
                            <div class="bullet bullet-dot w-40px h-40px bg-white border border-5 border-color-tgv"></div>
                        </div>
                        <div class="h-10px mx-3 w-100 bg-gray-300 bg-opacity-50 rounded w-40 position-relative" style="right: 12px">
                            <div class="bg-color-tgv rounded h-10px" role="progressbar" style="width: <?= $this->calcPercentTimeInPercent($planning->stations()->where('status', 'done')->orderBy('departure_at', 'desc')->first()->departure_at, $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first()->arrival_at) ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                <div class="position-relative">
                                    <img src="<?= asset('storage/icons/icon_tgv.png'); ?>" alt="" class="w-40px translate-middle" style="position: absolute;left: 104%;top: 5px;">
                                </div>
                            </div>
                        </div>
                        <div class="d-flex flex-column align-items-start justify-content-center position-relative" style="right: 26px">
                            <span class="fs-2 fw-bold text-color-tgv position-absolute m-5 text-center w-200px" style="top: 26px;right: -94px;"><?= $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first()->name ?></span>
                            <div class="bullet bullet-dot w-40px h-40px bg-white border border-5 border-color-tgv"></div>
                        </div>
                        <div class="separator border border-5 border-dotted border-color-tgv w-25 position-relative" style="right: 25px;"></div>
                    </div>
                </div>
            </div>
            <div id="kt_carousel_1_carousel" class="carousel carousel-custom slide" data-bs-ride="carousel" data-bs-interval="5000">
                <div class="carousel-inner">
                    <div class="carousel-item active">
                        <div class="d-flex flex-row justify-content-center align-items-center py-auto position-relative h-350px bg-opacity-5 bgi-no-repeat bgi-size-cover bgi-position-x-end " style="background-image: url('<?= asset('/storage/other/wall_wave_1.png') ?>');">
                            <div class="w-20 d-flex align-items-end justify-content-end position-relative">
                                <span class="text-white fw-lighter fs-3hx text-end">Vitesse Actuel de votre train</span>
                            </div>
                            <div class="w-20 d-flex align-items-baseline justify-content-end position-relative">
                                <span class="text-white fw-bold fs-7hx speedometer">301</span>
                                <span class="text-white fs-1 text-end">Km/h</span>
                            </div>
                        </div>
                    </div>
                        <?php if($planning->incidents()->where('niveau', '>=', 2)->count() != 0): ?>
                    <div class="carousel-item">
                        <div class="d-flex flex-row justify-content-center align-items-center h-350px">
                            <div class="w-25">
                                <iconify-icon icon="mdi:clock-warning" class="text-color-inoui opacity-20" width="230" height="230"></iconify-icon>
                            </div>
                            <div class="d-flex flex-column w-50">
                                <span class="fs-3x fw-bold text-white"><?= $planning->incidents()->where('niveau', '>=', 2)->first()->designation; ?></span>
                                <span class="fs-3x fw-bold text-gray-300">Nous avons environ <span class="text-yellow-600"><?= $planning->retarded_time; ?> <?= \Str::plural('minute', $planning->retarded_time) ?></span> de retard</span>
                            </div>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="carousel-item">
                        <div class="h-400px">
                            <table class="table table-striped table-inverse align-middle gx-7">
                                <tbody class="animation-dynamique-y">
                                    <?php foreach($planning->stations()->where('status', 'init')->orderBy('arrival_at')->limit(5)->get() as $station): ?>
                                <tr class="h-75px">
                                    <td class="w-200px text-center">
                                        <span class="fw-bold fs-1"><?= $station->arrival_at->format("H:i"); ?></span>
                                    </td>
                                    <td class="w-50px border border-left-5 border-color-tgv border-right-0 border-top-0 border-bottom-0 position-relative">
                                        <span class="bullet bullet-dot w-25px h-25px bg-white border border-5 border-color-tgv position-absolute" style="top: 25px;left: -15px;"></span>
                                    </td>
                                    <td class="text-white w-full">
                                        <span class="fw-bolder fs-2x"><?= $station->name; ?></span>
                                    </td>
                                </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        @endif
    @elseif($planning->status->value == 'in_station')
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
                    <div class="d-flex flex-column justify-content-center w-30 bg-gray-400 h-100 py-auto">
                        <div class="d-flex flex-column mb-5 mx-10">
                            <span class="fs-3 text-color-ter">Destination</span>
                            <div
                                class="fs-2x fw-bold text-gray-800"><?= $planning->userRailwayLigne->railwayLigne->end->name ?></div>
                        </div>
                        <div class="d-flex flex-column mb-5 mx-10">
                            <span class="fs-3 text-color-ter">Prochain arrets</span>
                            <div
                                class="fs-2x fw-bold text-gray-800"><?= $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first()->name ?></div>
                        </div>
                        <div class="d-flex flex-column mb-5 mx-10">
                            <span class="fs-3 text-color-ter">Arrivée prévue</span>
                            <div
                                class="fs-3x fw-bold text-gray-800"><?= $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first()->arrival_at->format("H:i") ?></div>
                        </div>
                    </div>
                    <div class="d-flex bg-white w-100 py-auto">
                        <div id="kt_carousel_1_carousel" class="carousel carousel-custom slide w-100 h-100"
                             data-bs-ride="carousel" data-bs-interval="5000">
                            <div class="carousel-inner">
                                <div class="carousel-item active">
                                    <div class="d-flex flex-column justify-content-center align-items-center h-100 w-100">
                                        <div class="fs-2x text-gray-800">Arret en gare de:</div>
                                        <div class="fs-5x fw-bolder text-color-ter"><?= $planning->stations()->where('status', 'arrival')->orWhere('status', 'departure')->orderBy('arrival_at')->first()->name ?></div>
                                    </div>
                                </div>
                            </div>
                        </div>
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
            @push("styles")
                <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
                      integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
                      crossorigin=""/>
                <link rel="stylesheet"
                      href="{{ asset('/plugins/custom/leaflet-routing-machine/dist/leaflet-routing-machine.css') }}">
            @endpush
            @push('scripts')
                @php
                    $station_start = $planning->stations()->where('status', 'done')->orderBy('departure_at', 'desc')->first();
                    $station_end = $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first();

                    $centerLat = ($station_start->railwayLigneStation->gare->latitude + $station_end->railwayLigneStation->gare->latitude) / 2;
                    $centerLng = ($station_start->railwayLigneStation->gare->longitude + $station_end->railwayLigneStation->gare->longitude) / 2;
                @endphp
                <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
                        integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
                        crossorigin=""></script>
                <script src="{{ asset('/plugins/custom/leaflet-routing-machine/dist/leaflet-routing-machine.js') }}"></script>
                <script src="{{ asset('/plugins/custom/leaflet-moving-marker/MovingMarker.js') }}"></script>
                <script type="text/javascript">

                    let mapStation = L.map('mapStation').setView([{{ $centerLat }}, {{ $centerLng }}], 12);
                    let iconStationStart = L.icon({
                        iconUrl: '{{ Storage::url('icons/railway/station.png') }}',
                        iconSize: [30, 30],
                    });
                    let iconStationEnd = L.icon({
                        iconUrl: '{{ Storage::url('icons/railway/station_end.png') }}',
                        iconSize: [30, 30],
                    });
                    let iconTrain = L.icon({
                        iconUrl: '{{ Storage::url('icons/railway/train_point.png') }}',
                        iconSize: [45, 45],
                    })

                    L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                        maxZoom: 19,
                        attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
                    }).addTo(mapStation);

                    let markerStationStart = L.marker([{{ $station_start->railwayLigneStation->gare->latitude }}, {{ $station_start->railwayLigneStation->gare->longitude }}], {icon: iconStationStart}).addTo(mapStation)
                    let markerStationEnd = L.marker([{{ $station_end->railwayLigneStation->gare->latitude }}, {{ $station_end->railwayLigneStation->gare->longitude }}], {icon: iconStationEnd}).addTo(mapStation)

                    mapStation.fitBounds([
                        markerStationStart.getLatLng(),
                        markerStationEnd.getLatLng()
                    ]);

                    let PolylineCoords = [
                        [{{ $station_start->railwayLigneStation->gare->latitude }}, {{ $station_start->railwayLigneStation->gare->longitude }}],
                        [{{ $station_end->railwayLigneStation->gare->latitude }}, {{ $station_end->railwayLigneStation->gare->longitude }}],
                    ];

                    let polylineStation = L.polyline(PolylineCoords, {color: 'red'}).addTo(mapStation)

                    let departureTime = new Date();
                    departureTime.setHours({{ $station_start->departure_at->format('H') }});
                    departureTime.setMinutes({{ $station_start->departure_at->format('i') }});

                    let arrivalTime = new Date();
                    arrivalTime.setHours({{ $station_end->arrival_at->format('H') }});
                    arrivalTime.setMinutes({{ $station_end->arrival_at->format('i') }});

                    let start = {
                        time: departureTime.getTime(),
                        lat: Number({{ $station_start->railwayLigneStation->gare->latitude }}),
                        lng: Number({{ $station_start->railwayLigneStation->gare->longitude }})
                    }

                    let end = {
                        time: arrivalTime.getTime(),  // Convertir les horaires de chaînes de caractères à des objets de Date
                        lat: Number({{ $station_end->railwayLigneStation->gare->latitude }}),
                        lng: Number({{ $station_end->railwayLigneStation->gare->longitude }})
                    }

                    let markerTrain = L.Marker.movingMarker([start, end], end.time - start.time, {icon: iconTrain}).addTo(mapStation)
                    mapStation.addLayer(markerTrain)

                    function interpolate(time, start, end) {
                        const latDiff = end.lat - start.lat;
                        const lngDiff = end.lng - start.lng;
                        const timeDiff = end.time - start.time;

                        const fractTime = (time - start.time) / timeDiff;

                        const newLat = start.lat + latDiff * fractTime;
                        const newLng = start.lng + lngDiff * fractTime;

                        return [newLat, newLng];
                    }

                    function updateTrainMarker() {
                        const now = new Date().getTime();

                        if(now > end.time || now < start.time) {
                            return;
                        }

                        const newLatLng = interpolate(now, start, end)
                        markerTrain.setLatLng(newLatLng);

                        setTimeout(updateTrainMarker, 15000)
                    }

                    function updateTime() {
                        const now = new Date();
                        const hours = now.getHours().toString().padStart(2, '0');
                        const minutes = now.getMinutes().toString().padStart(2, '0');
                        const seconds = now.getSeconds().toString().padStart(2, '0');

                        // Update UI elements with actual date/time
                        document.getElementById('clock-hours').textContent = hours;
                        document.getElementById('clock-minutes').textContent = minutes;
                        document.getElementById('clock-seconds').textContent = seconds;
                    }


                    updateTrainMarker()
                    updateTime()
                    setInterval(updateTime, 1000);
                </script>
            @endpush
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
                            <div class="d-flex align-items-center w-100">
                                <div class="separator border border-5 border-dotted border-color-tgv w-25"></div>
                                <div class="d-flex flex-column align-items-start justify-content-center position-relative">
                                    <span class="fs-2 fw-bold text-color-tgv position-absolute w-200px m-5" style="top: 26px;right: -94px;"><?= $planning->stations()->where('status', 'done')->orderBy('departure_at', 'desc')->first()->name ?></span>
                                    <div class="bullet bullet-dot w-40px h-40px bg-white border border-5 border-color-tgv"></div>
                                </div>
                                <div class="h-10px mx-3 w-100 bg-gray-300 bg-opacity-50 rounded w-40 position-relative" style="right: 12px">
                                    <div class="bg-color-tgv rounded h-10px" role="progressbar" style="width: <?= $this->calcPercentTimeInPercent($planning->stations()->where('status', 'done')->orderBy('departure_at', 'desc')->first()->departure_at, $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first()->arrival_at) ?>%;" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100">
                                        <div class="position-relative">
                                            <img src="<?= asset('storage/icons/icon_tgv.png'); ?>" alt="" class="w-40px translate-middle" style="position: absolute;left: 104%;top: 5px;">
                                        </div>
                                    </div>
                                </div>
                                <div class="d-flex flex-column align-items-start justify-content-center position-relative" style="right: 26px">
                                    <span class="fs-2 fw-bold text-color-tgv position-absolute m-5 text-center w-200px" style="top: 26px;right: -94px;"><?= $planning->stations()->where('status', 'init')->orderBy('arrival_at')->first()->name ?></span>
                                    <div class="bullet bullet-dot w-40px h-40px bg-white border border-5 border-color-tgv"></div>
                                </div>
                                <div class="separator border border-5 border-dotted border-color-tgv w-25 position-relative" style="right: 25px;"></div>
                            </div>
                        </div>
                    </div>
                    <div id="kt_carousel_1_carousel" class="carousel carousel-custom slide" data-bs-ride="carousel" data-bs-interval="5000">
                        <div class="carousel-inner">
                            <div class="carousel-item active">
                                <div class="d-flex flex-row justify-content-center align-items-center py-auto position-relative h-350px bg-opacity-5 bgi-no-repeat bgi-size-cover bgi-position-x-end " style="background-image: url('<?= asset('/storage/other/wall_wave_1.png') ?>');">
                                    <div class="w-20 d-flex align-items-end justify-content-end position-relative">
                                        <span class="text-white fw-lighter fs-3hx text-end">Vitesse Actuel de votre train</span>
                                    </div>
                                    <div class="w-20 d-flex align-items-baseline justify-content-end position-relative">
                                        <span class="text-white fw-bold fs-7hx speedometer">301</span>
                                        <span class="text-white fs-1 text-end">Km/h</span>
                                    </div>
                                </div>
                            </div>
                                <?php if($planning->incidents()->where('niveau', '>=', 2)->count() != 0): ?>
                            <div class="carousel-item">
                                <div class="d-flex flex-row justify-content-center align-items-center h-350px">
                                    <div class="w-25">
                                        <iconify-icon icon="mdi:clock-warning" class="text-color-inoui opacity-20" width="230" height="230"></iconify-icon>
                                    </div>
                                    <div class="d-flex flex-column w-50">
                                        <span class="fs-3x fw-bold text-white"><?= $planning->incidents()->where('niveau', '>=', 2)->first()->designation; ?></span>
                                        <span class="fs-3x fw-bold text-gray-300">Nous avons environ <span class="text-yellow-600"><?= $planning->retarded_time; ?> <?= \Str::plural('minute', $planning->retarded_time) ?></span> de retard</span>
                                    </div>
                                </div>
                            </div>
                            <?php endif; ?>
                            <div class="carousel-item">
                                <div class="h-400px d-flex flex-column justify-content-center align-items-center">
                                    <div class="fs-2x text-gray-300">Arret en gare de:</div>
                                    <div class="fs-5x text-color-inoui"><?= $planning->stations()->where('status', 'arrival')->orWhere('status', 'departure')->orderBy('arrival_at')->first()->name ?></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
        @endif
    @endif

</div>
