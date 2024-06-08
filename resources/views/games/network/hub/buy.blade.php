@extends('layouts.app')

@section("title")
    Achat d'un Hub
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Réseau Ferroviaire', 'hub', "Achat d'un hub"],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <div class="d-flex flex-row align-items-center">
                    <div class="symbol symbol-70px symbol-circle me-5">
                        <img src="{{ Storage::url('icons/railway/hub_checkout.png') }}" alt="">
                    </div>
                    <span class="fw-bold fs-2">Achat d'un Hub</span>
                </div>
                <x-game.network-menu />
            </div>
            <div class="card shadow-sm my-5">
                <div class="card-body">
                    <div id="mapHubs" style="width: 100%; height: 450px;"></div>
                </div>
            </div>
            @livewire('game.network.hub-checkout', ['hubs' => $hubs])
        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css" integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY=" crossorigin=""/>
    <link rel="stylesheet" href="{{ asset('/plugins/custom/leaflet-routing-machine/dist/leaflet-routing-machine.css') }}">
@endpush

@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script src="{{ asset('/plugins/custom/leaflet-routing-machine/dist/leaflet-routing-machine.js') }}"></script>

    <script type="text/javascript">
        let mapHubs = L.map('mapHubs').setView(['46.762443', '2.974984'], 6)
        let iconHubBuying = L.icon({
            iconUrl: '{{ Storage::url('icons/railway/map_buy.png') }}',
            iconSize: [30, 30],
        })
        let iconHub = L.icon({
            iconUrl: '{{ Storage::url('icons/railway/map_not_buy.png') }}',
            iconSize: [30, 30],
        })

        L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
            maxZoom: 19,
            attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
        }).addTo(mapHubs);

        @foreach(\App\Models\Railway\Gare\RailwayHub::where('active', true)->get() as $hub)
            @if(!auth()->user()->userRailwayHub()->where('railway_hub_id', $hub->id)->exists())
                L.marker([{{ $hub->gare->latitude }}, {{ $hub->gare->longitude }}], {icon: iconHub}).addTo(mapHubs)
            @else
                L.marker([{{ $hub->gare->latitude }}, {{ $hub->gare->longitude }}], {icon: iconHubBuying}).addTo(mapHubs)
           @endif
        @endforeach
    </script>
@endpush

