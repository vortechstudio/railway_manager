@extends('layouts.app')

@section("title")
    Réseau
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Réseau Ferroviaire'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.network-menu />
            <div class="card shadow-sm mb-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-9 mb-5">
                            <div id="map" style="height: 500px">
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-3 mb-5">
                            <h3 class="card-title">Filtres</h3>
                            @livewire('game.core.delivery-list')
                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <livewire:game.network.hub-list />
                    <livewire:game.network.ligne-list />
                </div>
            </div>
        </div>
    </div>
@endsection

@push("styles")
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <link rel="stylesheet"
          href="{{ asset('/plugins/custom/leaflet-routing-machine/dist/leaflet-routing-machine.css') }}">
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script src="{{ asset('/plugins/custom/leaflet-routing-machine/dist/leaflet-routing-machine.js') }}"></script>
    <script src="{{ asset('/plugins/custom/leaflet-moving-marker/MovingMarker.js') }}"></script>
    <script>
        let map = L.map('map').setView([47.158403, 2.228246], 6)
        let hubs = @json($hubs);

        let iconHub = L.icon({
            iconUrl: '{{ Storage::url('icons/railway/station.png') }}',
            iconSize: [30, 30],
        });
        let iconEnd = L.icon({
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
        }).addTo(map);

        hubs.forEach(hub => {
            console.log(hub)
            let marker = L.marker([hub.railway_hub.gare.latitude, hub.railway_hub.gare.longitude], {icon: iconHub}).addTo(map)
            marker.bindPopup(`
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row align-items-center gap-3 mb-3">
                        <div class="symbol symbol-30px">
                            <img src="{{ Storage::url('icons/railway/station.png') }}" alt="">
                        </div>
                        <span class="text-danger fw-bold">${hub.railway_hub.gare.name}</span>
                    </div>
                    @livewire('game.core.screen-departure')
                </div>
            `)

            hub.user_railway_ligne.forEach(ligne => {

                console.log(ligne)
                let marker = L.marker([ligne.railway_ligne.end.latitude, ligne.railway_ligne.end.longitude], {icon: iconEnd}).addTo(map)
                marker.bindPopup(`
                <div class="d-flex flex-column">
                    <div class="d-flex flex-row align-items-center gap-3 mb-3">
                        <div class="symbol symbol-30px">
                            <img src="{{ Storage::url('icons/railway/station_end.png') }}" alt="">
                        </div>
                        <span class="text-danger fw-bold">Ligne ${ligne.railway_ligne.start.name} <-> ${ligne.railway_ligne.end.name}</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center">
                        <span>Prochain départ</span>
                        <span class="fw-bold">${ligne.next_departure !== null ? ligne.next_departure.date_depart : 'Aucun Départ'}</span>
                    </div>
                </div>
                `)
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
                ligne.railway_ligne.stations.forEach(station => {
                    latLngPolyline.push([station.gare.latitude, station.gare.longitude])
                })

                L.polyline(latLngPolyline, {
                    color: lineTypeColor[ligne.railway_ligne.type] || 'black',
                    weight: 5,
                }).addTo(map)

            })
        })

    </script>
    <script>
        $(document).ready(function () {
            setInterval(function () {
                $('span[data-countdown-delivery]').each(function () {
                    let endAtTimestamp = $(this).data('countdown-delivery')
                    let nowTimestamp = Math.floor($.now() / 1000);
                    let diffSecs = endAtTimestamp - nowTimestamp;

                    if(diffSecs <= 0) {
                        $(this).closest('.card').hide()
                    } else {
                        let displayTime = diffSecs > 60 ? Math.floor(diffSecs / 60) + ' min' : diffSecs + ' secondes';
                        $(this).text(displayTime)

                        let progressBar = $(this).closest(".card").find(".bg-black").children();
                        console.log(progressBar)

                        if(progressBar.length) {
                            let totalTimeSecs = progressBar.data('total-time');
                            let elapsedPercentage = 100 - Math.floor((diffSecs / totalTimeSecs) * 100)
                            progressBar.css('width', elapsedPercentage + '%');
                            progressBar.attr('aria-valuenow', elapsedPercentage)
                        }
                    }
                })
            }, 1000);
        })
    </script>
@endpush

