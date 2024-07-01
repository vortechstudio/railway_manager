@extends('layouts.app')

@section("title")
    Détail d'une ligne
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Réseau Ferroviaire', 'Ligne', $ligne->railwayLigne->start->name.' <-> '.$ligne->railwayLigne->end->name],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.network-menu/>
            <div
                class="d-flex flex-row justify-content-between align-items-center rounded-1 bg-gray-800 text-white gap-3 mb-5 p-2">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-70px symbol-circle bg-gray-400 me-2">
                        <img src="{{ Storage::url('icons/railway/ligne.png') }}" alt="">
                    </div>
                    <span class="fw-bold">Détail d'une ligne</span>
                </div>
                <ul class="nav nav-pills nav-pills-custom " role="tablist">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Détail de la ligne">
                        <a href="#detail" class="nav-link active border-0 bg-active-light text-active-dark"
                           data-bs-toggle="tab">
                            <i class="fa-solid fa-search text-white fs-2x"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Liste des Trajets">
                        <a href="#travels" class="nav-link border-0 bg-active-light text-active-dark"
                           data-bs-toggle="tab">
                            <i class="fa-solid fa-route text-white fs-2x"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top"
                        data-bs-title="Vendre la ligne">
                        <a href="#selling" class="nav-link border-0 bg-active-danger text-active-light"
                           data-bs-toggle="tab">
                            <i class="fa-solid fa-shopping-cart text-white fs-2x"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="detail" role="tabpanel">
                    <div id="mapLigne" class="mb-5 rounded-3" style="height: 500px"></div>
                    @livewire('game.core.screen-departure', ["type" => "ligne", "ligne" => $ligne])
                    @livewire('game.network.ligne-detail', ["ligne" => $ligne])
                </div>
                <div class="tab-pane fade" id="travels" role="tabpanel">
                    @livewire('game.planning.planning-list-by-date', ["type" => "ligne", "ligne" => $ligne])
                </div>
                <div class="tab-pane fade" id="selling" role="tabpanel">
                    @livewire('game.network.ligne-selling', ["ligne" => $ligne])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script src="{{ asset('/plugins/custom/leaflet-moving-marker/MovingMarker.js') }}"></script>

    @php
        $centerLat = ($ligne->railwayLigne->start->latitude + $ligne->railwayLigne->end->latitude) / 2;
        $centerLng = ($ligne->railwayLigne->start->longitude + $ligne->railwayLigne->end->longitude) / 2;
    @endphp
    <script>
        let mapLigne = L.map('mapLigne').setView([{{ $centerLat }}, {{ $centerLng }}], 8)
        let ligne = @json($ligne);

        let iconStationStart = L.icon({
            iconUrl: '{{ Storage::url('icons/railway/station_hub.png') }}',
            iconSize: [30, 30],
        });

        let iconStation = L.icon({
            iconUrl: '{{ Storage::url('icons/railway/station.png') }}',
            iconSize: [15, 15],
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
        }).addTo(mapLigne);

        console.log(ligne)
        let latLngPolyline = []
        let lineTypeColor = {
            'ter': '#034EA2',
            'tgv': '#9b2743',
            'intercity': '#7B1791',
            'tram': 'black',
            'transilien': '#83BF00',
            'metro': 'black',
            'other': 'black',
        }
        let markerStart;
        let markerEnd;

        ligne.railway_ligne.stations.forEach(station => {
            console.log(station)
            if (station.railway_gare_id === ligne.railway_ligne.start_gare_id) {
                markerStart = L.marker([station.gare.latitude, station.gare.longitude], {icon: iconStationStart}).addTo(mapLigne)
                markerStart.bindPopup(`
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row align-items-center gap-3 mb-3">
                        <div class="symbol symbol-30px">
                            <img src="{{ Storage::url('icons/railway/station.png') }}" alt="">
                        </div>
                        <span class="text-danger fw-bold">${station.gare.name}</span>
                    </div>
                    @livewire('game.core.screen-departure')
                </div>
                `)
            } else if (station.railway_gare_id === ligne.railway_ligne.end_gare_id) {
                markerEnd = L.marker([station.gare.latitude, station.gare.longitude], {icon: iconStationEnd}).addTo(mapLigne)
                markerEnd.bindPopup(`
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row align-items-center gap-3 mb-3">
                        <div class="symbol symbol-30px">
                            <img src="{{ Storage::url('icons/railway/station.png') }}" alt="">
                        </div>
                        <span class="text-danger fw-bold">${station.gare.name}</span>
                    </div>
                    @livewire('game.core.screen-departure')
                </div>
                `)
            } else {
                let marker = L.marker([station.gare.latitude, station.gare.longitude], {icon: iconStation}).addTo(mapLigne)
                marker.bindPopup(`${station.gare.name}`)
            }
            latLngPolyline.push([station.gare.latitude, station.gare.longitude])
        })

        L.polyline(latLngPolyline, {
            color: lineTypeColor[ligne.railway_ligne.type] || 'black',
            weight: 5,
        }).addTo(mapLigne)

        mapLigne.fitBounds([
            markerStart.getLatLng(),
            markerEnd.getLatLng()
        ]);

        @if($ligne->next_departure)
        let departureTime = new Date();
        departureTime.setHours({{ $ligne->next_departure->date_depart->format('H') }});
        departureTime.setMinutes({{ $ligne->next_departure->date_depart->format('i') }});

        let arrivalTime = new Date();
        arrivalTime.setHours({{ $ligne->next_departure->date_arrived->format('H') }});
        arrivalTime.setMinutes({{ $ligne->next_departure->date_arrived->format('i') }});

        let start = {
            time: departureTime.getTime(),
            lat: Number({{ $ligne->railwayLigne->start->latitude }}),
            lng: Number({{ $ligne->railwayLigne->start->longitude }})
        }

        let end = {
            time: arrivalTime.getTime(),
            lat: Number({{ $ligne->railwayLigne->end->latitude }}),
            lng: Number({{ $ligne->railwayLigne->end->longitude }})
        }
        let markerTrain = L.Marker.movingMarker([start, end], end.time - start.time, {icon: iconTrain}).addTo(mapLigne)
        mapLigne.addLayer(markerTrain)

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

        updateTrainMarker()

        @endif
    </script>
@endpush

