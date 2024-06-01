@extends('layouts.app')

@section("title")
    Feuille de route
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Réseau Ferroviaire', 'Ligne', $planning->userRailwayLigne->railwayLigne->type->name.' '.$planning->number_travel],
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
                        <img src="{{ Storage::url('icons/railway/train_animated.gif') }}" alt="">
                    </div>
                    <span class="fw-bold">Feuille de route: {{ $planning->userRailwayLigne->railwayLigne->type->name }} {{ $planning->number_travel }}</span>
                </div>
                <div class="d-flex align-items-center">
                    <span class="badge bg-blue-600 text-white me-3">Ligne</span>
                    <span class="fw-bold fs-3">{{ $planning->userRailwayLigne->railwayLigne->start->abr }} / {{ $planning->userRailwayLigne->railwayLigne->end->abr }}</span>
                </div>
            </div>
            <div class="card shadow-sm mb-5">
                <div class="card-header">
                    <h3 class="card-title">&nbsp;</h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-pills nav-pills-custom" role="tablist">
                            @if($isPremium)
                            <li class="nav-item">
                                <a href="#screen" class="nav-link border-0 bg-light bg-active-primary {{ $isPremium ? 'active' : '' }}" data-bs-toggle="tab">
                                    Ecran
                                </a>
                            </li>
                            @endif
                            <li class="nav-item">
                                <a href="#table" class="nav-link border-0 bg-light bg-active-primary {{ !$isPremium ? 'active' : '' }}" data-bs-toggle="tab">
                                    Tableau
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        @if($isPremium)
                        <div class="tab-pane fade {{ $isPremium  ? 'show active' : '' }}" id="screen" role="tabpanel">
                            @livewire('game.core.screen.ecran', ["planning" => $planning])
                        </div>
                        @endif
                        <div class="tab-pane fade {{ !$isPremium ? 'show active' : '' }}" id="table" role="tabpanel">
                            @livewire('game.core.screen.screen-table', ["planning" => $planning])
                        </div>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-sm-12 col-lg-8 mb-5">
                    <div class="card shadow-sm mb-5">
                        <div class="card-header">
                            <h3 class="card-title">Rapport sur le trajet {{ $planning->userRailwayEngine->railwayEngine->type_transport->name }} N° {{ $planning->number_travel }} à destination de {{ $planning->userRailwayLigne->railwayLigne->end->name }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6 mb-5">
                                    <x-base.underline
                                        title="Détail du trajet"
                                        size="3"
                                        size-text="fs-1" />

                                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                        <span>Gare de départ</span>
                                        <span>{{ $planning->userRailwayLigne->railwayLigne->start->name }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                        <span>Heure de départ</span>
                                        <span>{{ $planning->date_depart->format("H:i") }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                        <span>Gare d'arrivée</span>
                                        <span>{{ $planning->userRailwayLigne->railwayLigne->end->name }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                        <span>Heure d'arrivée</span>
                                        <span>{{ $planning->date_depart->addMinutes($planning->userRailwayLigne->railwayLigne->time_min)->format("H:i") }}</span>
                                    </div>
                                    @if($planning->status->value == 'travel' && $planning->stations()->where('status', 'init')->count() > 0)
                                        <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                            <span>Prochaine Gare</span>
                                            <span>{{ $planning->stations()->where('status', 'init')->first()->name }}</span>
                                        </div>
                                    @endif
                                </div>
                                <div class="col-sm-12 col-lg-6 mb-5">
                                    <x-base.underline
                                        title="Composition"
                                        size="3"
                                        size-text="fs-1" />
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                        <span>Nombre de voyageurs</span>
                                        <span>{{ $planning->passengers()->sum('nb_passengers') }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($planning->status->value == 'arrival')
                        <div class="card shadow-sm">
                            <div class="card-header">
                                <h3 class="card-title">Résultat Financier</h3>
                            </div>
                            <div class="card-body">
                                <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                    <span>Chiffre d'affaire</span>
                                    <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($planning->travel->getCA()) }}</span>
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center mb-2 fs-italic ms-10">
                                    <span>dont CA Billetterie</span>
                                    <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($planning->travel->ca_billetterie) }}</span>
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center mb-2 fs-italic ms-10 mb-10">
                                    <span>dont revenues auxiliaires</span>
                                    <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($planning->travel->ca_other) }}</span>
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                    <span>Coût du trajet</span>
                                    <span class="text-red-600">- {{ \Vortechstudio\Helpers\Facades\Helpers::eur($planning->travel->getCoast()) }}</span>
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center mb-2 fs-italic ms-10">
                                    <span>dont Frais de Gasoil</span>
                                    <span class="text-red-600">- {{ Vortechstudio\Helpers\Facades\Helpers::eur($planning->travel->fee_gasoil) }}</span>
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center fs-italic ms-10">
                                    <span>dont Frais d'electricité</span>
                                    <span class="text-red-600">{{ Vortechstudio\Helpers\Facades\Helpers::eur($planning->travel->fee_electrique) }}</span>
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center fs-italic ms-10 mb-20">
                                    <span>dont autres charges</span>
                                    <span class="text-red-600">{{ Vortechstudio\Helpers\Facades\Helpers::eur($planning->travel->fee_other) }}</span>
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                    <span>Résultat du trajet</span>
                                    <span class="fs-3 fw-bold">{{ Vortechstudio\Helpers\Facades\Helpers::eur($planning->travel->getResultat()) }}</span>
                                </div>
                                @if($planning->incidents()->count() > 0)
                                    <div class="d-flex flex-row justify-content-between align-items-center mb-2">
                                        <span>Coût des incidents</span>
                                        <span class="fs-4 fw-bold text-red-400">{{ Vortechstudio\Helpers\Facades\Helpers::eur($planning->incidents()->sum('amount_reparation')) }}</span>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endif
                    <div class="card shadow-sm mt-5">
                        <div class="card-header">
                            <h3 class="card-title">Incidents durant le trajet</h3>
                        </div>
                        <div class="card-body">
                            @if($planning->incidents()->count() == 0)
                                <x-base.alert
                                type="success"
                                icon="fa-solid fa-check-circle"
                                title="Aucun incident"
                                content="Aucun incident n'a été signalé sur ce trajet" />
                            @else
                                <livewire:game.engine.incident-list type="planning" :planning="$planning" showing="simple" />
                            @endif
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">Message du trajet</h3>
                        </div>
                        <div class="card-body">
                            <table class="table">
                                <tbody>
                                @if(count($planning->logs) > 0)
                                    @foreach($planning->logs as $log)
                                        <tr>
                                            <td>{{ $log->created_at->format('d/m/Y H:i') }}</td>
                                            <td>{{ $log->message }}</td>
                                        </tr>
                                    @endforeach
                                @else
                                    <tr>
                                        <td colspan="2"><x-base.is-null text="Aucun message actuellement" /></td>
                                    </tr>
                                @endif
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

