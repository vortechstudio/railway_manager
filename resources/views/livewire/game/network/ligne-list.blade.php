<div>
    <div id="mapLigne" class="mb-5" style="height: 500px;"></div>
    @if(count($lignes) == 0)
        <x-base.is-null
            text="Aucune Ligne active actuellement"/>
    @else
        @foreach($lignes as $ligne)
            <div class="d-flex flex-column bg-white p-5 mb-5 rounded-2">
                <div
                    class="d-flex flex-row justify-content-between align-items-center border border-bottom-2 border-top-0 border-left-0 border-right-0 pb-1 mb-5">
                    <div class="d-flex align-items-center">
                        <span class="badge bagde-circle badge-primary text-white me-2">Ligne</span>
                        <span
                            class="fw-bold fs-3">{{ $ligne->railwayLigne->start->name }} <-> {{ $ligne->railwayLigne->end->name }}</span>
                    </div>
                    <a href="{{ route('network.line.show', $ligne->id) }}"
                       class="btn btn-flex bg-blue-600 bg-hover-primary">
                                <span class="symbol symbol-35px me-2">
                                    <img src="{{ Storage::url('icons/railway/ligne.png') }}" alt="">
                                </span>
                        <span class="text-white">Détail de la ligne</span>
                    </a>
                </div>
                <div class="d-flex flex-row align-items-center">
                    {!! $ligne->ratio_performance !!}
                    <div class="d-flex align-items-center me-5">
                        <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                        <span class="me-2">Distance: </span>
                        <span class="fw-bold">{{ $ligne->railwayLigne->distance }} Km</span>
                    </div>
                    <div class="d-flex align-items-center me-5">
                        <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                        <span class="me-2">Offre Actuel: </span>
                        <span class="fw-bold">{{ $ligne->getActualOffreLigne() }} P</span>
                    </div>
                    <div class="d-flex align-items-center me-5">
                        <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                        <span class="me-2">Chiffre d'affaires: </span>
                        <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCA()) }}</span>
                    </div>
                    <div class="d-flex align-items-center me-5">
                        <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                        <span class="me-2">Bénéfices: </span>
                        <span
                            class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getBenefice()) }}</span>
                    </div>

                </div>
            </div>
        @endforeach
    @endif
</div>

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
