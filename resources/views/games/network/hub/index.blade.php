@extends('layouts.app')

@section("title")
    Détail d'un Hub
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Réseau Ferroviaire', 'hub', $hub->railwayHub->gare->name],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.network-menu />
            <div class="d-flex flex-row justify-content-between align-items-center rounded-1 bg-gray-800 text-white gap-3 mb-5 p-2">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-70px symbol-circle bg-gray-400 me-2">
                        <img src="{{ Storage::url('icons/railway/hub.png') }}" alt="">
                    </div>
                    <span class="fw-bold">Détail d'un hub</span>
                </div>
                <ul class="nav nav-pills nav-pills-custom " role="tablist">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Détail du hub">
                        <a href="#detail" class="nav-link active border-0 bg-active-light text-active-dark" data-bs-toggle="tab">
                            <i class="fa-solid fa-search text-white fs-2x"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Liste des lignes">
                        <a href="#lignes" class="nav-link border-0 bg-active-light text-active-dark" data-bs-toggle="tab">
                            <i class="fa-solid fa-code-commit text-white fs-2x"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Liste des rames">
                        <a href="#rames" class="nav-link border-0 bg-active-light text-active-dark" data-bs-toggle="tab">
                            <i class="fa-solid fa-train text-white fs-2x"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Liste des Trajets">
                        <a href="#travels" class="nav-link border-0 bg-active-light text-active-dark" data-bs-toggle="tab">
                            <i class="fa-solid fa-route text-white fs-2x"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Rentes">
                        <a href="#rents" class="nav-link border-0 bg-active-light text-active-dark" data-bs-toggle="tab">
                            <i class="fa-solid fa-shop text-white fs-2x"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Vendre le hub">
                        <a href="#selling" class="nav-link border-0 bg-active-danger text-active-light" data-bs-toggle="tab">
                            <i class="fa-solid fa-shopping-cart text-white fs-2x"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="detail" role="tabpanel">
                    <livewire:game.network.hub-detail-panel :hub="$hub" />
                </div>
                <div class="tab-pane fade" id="lignes" role="tabpanel">
                    <div id="mapLigne" class="mb-5" style="height: 500px;"></div>
                    <livewire:game.network.ligne-list type="hub" :hub="$hub" />
                </div>
                <div class="tab-pane fade" id="rames" role="tabpanel">
                    <livewire:game.engine.engine-list type="hub" :hub="$hub" />
                </div>
                <div class="tab-pane fade" id="travels" role="tabpanel">
                    <livewire:game.planning.planning-list-by-date type="hub" :hub="$hub" />
                </div>
                <div class="tab-pane fade" id="rents" role="tabpanel">
                    @livewire('game.network.hub-rent-panel', ['hub' => $hub])
                </div>
                <div class="tab-pane fade" id="selling" role="tabpanel">
                    @livewire('game.network.hub-selling', ['hub' => $hub])
                </div>
            </div>
        </div>
    </div>
@endsection

@push("styles")
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
@endpush

@if(isset($hub))
    @push("scripts")
        <script>
            let mapLigne = L.map('mapLigne').setView([{{ $hub->railwayHub->gare->latitude }}, {{ $hub->railwayHub->gare->longitude }}], 10)
            let iconHub = L.icon({
                iconUrl: '{{ Storage::url('icons/railway/station_hub.png') }}',
                iconSize: [30, 30],
            });
            let iconStation = L.icon({
                iconUrl: '{{ Storage::url('icons/railway/station.png') }}',
                iconSize: [30, 30],
            });
            let iconEnd = L.icon({
                iconUrl: '{{ Storage::url('icons/railway/station_end.png') }}',
                iconSize: [30, 30],
            });
            let hub = @json($hub)

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(mapLigne);

            let markerHubLigne = L.marker([{{ $hub->railwayHub->gare->latitude }}, {{ $hub->railwayHub->gare->longitude }}], {icon: iconHub}).addTo(mapLigne)

            markerHubLigne.bindPopup(`
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
                let marker = L.marker([ligne.railway_ligne.end.latitude, ligne.railway_ligne.end.longitude], {icon: iconEnd}).addTo(mapLigne)
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
                }).addTo(mapLigne)
            })
        </script>
    @endpush
@endif


