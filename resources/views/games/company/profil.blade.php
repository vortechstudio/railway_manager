@extends('layouts.app')

@section("title")
    Profil de la compagnie
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Compagnie', 'Profil de la compagnie'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.company-menu />
            <div class="card shadow-sm animated-background h-auto text-white mb-5">
                <div class="card-body">
                    <div class="d-flex justify-content-between">
                        <div class="d-flex">
                            <div class="symbol symbol-100px me-3">
                                <img src="{{ auth()->user()->socials()->first()->avatar }}" alt="">
                            </div>
                            <span class="fs-2x fw-bolder">{{ auth()->user()->railway->name_company }}</span>
                        </div>
                        <div class="d-flex flex-row">
                            <div class="d-flex flex-column align-items-end">
                                <span class="fs-3 fw-semibold">Classement</span>
                                <span class="fs-1 fw-bold">{{ auth()->user()->railway->ranking }}</span>
                            </div>
                            <div class="vr mx-2"></div>
                            <div class="d-flex flex-column align-items-end">
                                <span class="fs-3 fw-semibold">Niveau</span>
                                <span class="fs-1 fw-bold">{{ auth()->user()->railway->level }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="w-75 mx-auto p-5 rounded-3 bg-gray-100">
                <ul class="nav nav-tabs nav-line-tabs nav-line-tabs-2x mb-5 fs-6">
                    <li class="nav-item">
                        <a class="nav-link active" data-bs-toggle="tab" href="#general">Général</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" data-bs-toggle="tab" href="#network">Réseau & Flotte</a>
                    </li>
                </ul>
                <div class="tab-content" id="myTabContent">
                    <div class="tab-pane fade show active" id="general" role="tabpanel">
                        <div class="bgi-no-repeat bgi-size-cover bgi-position-center h-300px w-100 rounded-2 mb-5" style="background: url('{{ Storage::url("services/{$service->id}/wall_login.png") }}')">
                            <div class="d-flex flex-end p-5">
                                <div class="d-flex flex-column w-35 bg-white bg-opacity-50 rounded-2 p-2">
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span>Directeur:</span>
                                        <span class="fw-bold">{{ $user->name }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span>Secrétaire:</span>
                                        <span class="fw-bold">{{ $user->railway->name_secretary }}</span>
                                    </div>
                                    <div class="d-flex justify-content-between align-items-center mb-1">
                                        <span>Conseiller:</span>
                                        <span class="fw-bold">{{ $user->railway->name_conseiller }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-6 mb-5">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Date de création:</span>
                                    <span class="fw-bold">{{ auth()->user()->services()->where('service_id', $service->id)->first()->created_at->format('d/m/Y') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Valorisation:</span>
                                    <span class="fw-bold">{{ Helpers::eur(auth()->user()->railway_company->valorisation) }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-5">
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Dernière connexion:</span>
                                    <span class="fw-bold">{{ auth()->user()->lastSuccessfulLoginAt()->format('d/m/Y à H:i') }}</span>
                                </div>
                                <div class="d-flex justify-content-between mb-1">
                                    <span>Solde:</span>
                                    <span class="fw-bold">{{ Helpers::eur(auth()->user()->railway->argent) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                            <div class="col-sm-12 col-lg-6 mb-5">
                                <x-base.title title="PASSAGERS" />
                                <div class="d-flex rounded-1 bg-white justify-content-between align-items-center p-2 mb-1">
                                    <span class="fs-4">Distraction:</span>
                                    <span class="fw-bold fs-4">Niveau {{ $user->railway_company->distraction }}</span>
                                </div>
                                <div class="d-flex rounded-1 bg-white justify-content-between align-items-center p-2 mb-1">
                                    <span class="fs-4">Attractivité des tarifs:</span>
                                    <span class="fw-bold fs-4">Niveau {{ $user->railway_company->tarification }}</span>
                                </div>
                                <div class="d-flex rounded-1 bg-white justify-content-between align-items-center p-2 mb-1">
                                    <span class="fs-4">Ponctualité:</span>
                                    <span class="fw-bold fs-4">Niveau {{ $user->railway_company->ponctualite }}</span>
                                </div>
                                <div class="d-flex rounded-1 bg-white justify-content-between align-items-center p-2 mb-1">
                                    <span class="fs-4">Securité:</span>
                                    <span class="fw-bold fs-4">Niveau {{ $user->railway_company->securite }}</span>
                                </div>
                                <div class="d-flex rounded-1 bg-white justify-content-between align-items-center p-2 mb-1">
                                    <span class="fs-4">Confort:</span>
                                    <span class="fw-bold fs-4">Niveau {{ $user->railway_company->confort }}</span>
                                </div>
                                <div class="d-flex rounded-1 bg-white justify-content-between align-items-center p-2 mb-1">
                                    <span class="fs-4">Revenues Auxilliaires:</span>
                                    <span class="fw-bold fs-4">Niveau {{ $user->railway_company->rent_aux }}</span>
                                </div>
                                <div class="d-flex rounded-1 bg-white justify-content-between align-items-center p-2 mb-1">
                                    <span class="fs-4">Frais:</span>
                                    <span class="fw-bold fs-4">Niveau {{ $user->railway_company->frais }}</span>
                                </div>
                            </div>
                            <div class="col-sm-12 col-lg-6 mb-5">
                                <x-base.title title="FRET & ASSIMILE" />
                                <div class="d-flex rounded-1 bg-white justify-content-between align-items-center p-2 mb-1">
                                    <span class="fs-4">Livraison:</span>
                                    <span class="fw-bold fs-4">Niveau {{ $user->railway_company->livraison }}</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="tab-pane fade" id="network">
                        <div class="bg-gray-600 rounded-2 border border-3 border-gray-900 p-5 w-100 mb-10 shadow-lg">
                            <div id="mapAll" style="height: 350px"></div>
                        </div>
                        <div class="d-flex flex-column mb-10 w-75">
                            <div class="d-flex justify-content-between align-items-center fs-4 mb-1 p-5 bg-white rounded-2">
                                <span>Nombre de Hubs</span>
                                <span>{{ auth()->user()->userRailwayHub->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center fs-4 mb-1 p-5 bg-white rounded-2">
                                <span>Nombre de rames</span>
                                <span>{{ auth()->user()->railway_engines->count() }}</span>
                            </div>
                            <div class="d-flex justify-content-between align-items-center fs-4 mb-1 p-5 bg-white rounded-2">
                                <span>Nombre de lignes</span>
                                <span>{{ auth()->user()->userRailwayLigne->count() }}</span>
                            </div>
                        </div>
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Rames de la compagnie</h3>
                            </div>
                            <div class="card-body h-500px scroll">
                                <div class="row">
                                    @foreach(auth()->user()->railway_engines as $engine)
                                    <div class="col-sm-6 col-lg-3 mb-3">
                                        <div class="d-flex flex-column">
                                            <img src="{{ $engine->railwayEngine->getFirstImage($engine->railwayEngine->id) }}" class="img-fluid" alt="">
                                            <div class="d-flex justify-content-center align-items-center">
                                                <span>{{ $engine->railwayEngine->name }}</span>
                                            </div>
                                        </div>
                                    </div>
                                    @endforeach
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </div>
@endsection

@push('styles')
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.9.4/dist/leaflet.css"
          integrity="sha256-p4NxAoJBhIIN+hmNHrzRCf9tD/miZyoHS5obTRR9BMY="
          crossorigin=""/>
    <link rel="stylesheet"
          href="{{ asset('/plugins/custom/leaflet-routing-machine/dist/leaflet-routing-machine.css') }}">
@endpush
@php
    $centerLat = 0;
    $centerLng = 0;

    foreach (auth()->user()->userRailwayHub as $hub) {
        $centerLat += $hub->railwayHub->gare->latitude / 2;
        $centerLng += $hub->railwayHub->gare->longitude / 2;
    }

    foreach (auth()->user()->userRailwayLigne as $ligne) {
        $centerLat += $ligne->railwayLigne->end->latitude / 2;
        $centerLng += $ligne->railwayLigne->end->longitude / 2;
    }
@endphp
@push('scripts')
    <script src="https://unpkg.com/leaflet@1.9.4/dist/leaflet.js"
            integrity="sha256-20nQCchB9co0qIjJZRGuk2/Z9VM+kNiyxNV1lvTlZBo="
            crossorigin=""></script>
    <script src="{{ asset('/plugins/custom/leaflet-routing-machine/dist/leaflet-routing-machine.js') }}"></script>
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            let mapAll = L.map('mapAll').setView([{{ $centerLat }}, {{ $centerLng }}], 6);
            let iconHub = L.icon({
                iconUrl: '{{ Storage::url('icons/railway/station_hub.png') }}',
                iconSize: [40, 40],
            });
            let iconEnd = L.icon({
                iconUrl: '{{ Storage::url('icons/railway/station_end.png') }}',
                iconSize: [30, 30],
            })

            L.tileLayer('https://tile.openstreetmap.org/{z}/{x}/{y}.png', {
                maxZoom: 19,
                attribution: '&copy; <a href="http://www.openstreetmap.org/copyright">OpenStreetMap</a>'
            }).addTo(mapAll);

            let hubs = Array.from(@json(auth()->user()->userRailwayHub))
            hubs.forEach(hub => {
                L.marker([hub.railway_hub.gare.latitude,hub.railway_hub.gare.longitude], {icon: iconHub}).addTo(mapAll)
            })

            let lignes = Array.from(@json(auth()->user()->userRailwayLigne))
            lignes.forEach(ligne => {
                L.marker([ligne.railway_ligne.end.latitude,ligne.railway_ligne.end.longitude], {icon: iconEnd}).addTo(mapAll)


                let polyline = L.polyline([
                    [ligne.railway_ligne.start.latitude, ligne.railway_ligne.start.longitude],
                    [ligne.railway_ligne.end.latitude, ligne.railway_ligne.end.longitude],
                ], {color: 'red'}).addTo(mapAll)

                let lng = polyline.getCenter()
                console.log(lng)
                let popup = L.popup()
                    .setContent(ligne.railway_ligne.name)

                polyline.on('click', () => {
                    popup.setLatLng(lng)
                    mapAll.openPopup(popup)
                })

            })
        })
    </script>
@endpush

