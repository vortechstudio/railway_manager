@extends('layouts.app')

@section("title")
    Statistiques Globales
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Compagnie', 'Statistiques Globales'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.company-menu />
            <div class="card shadow-sm">
                <div class="card-body">
                    <x-base.title title="Progression des Hubs" />
                    <div class="d-flex flex-column mb-5">
                        @foreach(auth()->user()->userRailwayHub as $hub)
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span>{{ $hub->railwayHub->gare->name }}</span>
                                <span>{!! $hub->getRatioPerformance() !!}</span>
                            </div>
                        @endforeach
                    </div>
                    <x-base.title title="Votre compagnie" />
                    <div class="d-flex flex-column w-50 mb-5">
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Chiffre d'affaire</span>
                            <span>{{ Helpers::eur((new \App\Services\Models\User\Railway\UserRailwayCompanyAction(auth()->user()->railway_company))->getCA(now()->subDays(7)->startOfDay(), now()->subDay()->endOfDay())) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Nombre Total de passagers</span>
                            <span>{{ (new \App\Services\Models\User\Railway\UserRailwayCompanyAction(auth()->user()->railway_company))->getTotalPassengers(now()->subDays(7)->startOfDay(), now()->subDay()->endOfDay()) }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Nombre de rames</span>
                            <span>{{ auth()->user()->railway_engines->count() }}</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center mb-2">
                            <span>Kilométrage de ligne total</span>
                            <span>{{ (new \App\Services\Models\User\Railway\UserRailwayCompanyAction(auth()->user()->railway_company))->getKilometrageTotal() }} Km</span>
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
            </div>
        </div>
    </div>
@endsection

@push('scripts')
    <script>

    </script>
@endpush

