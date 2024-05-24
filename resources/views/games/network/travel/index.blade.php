@extends('layouts.app')

@section("title")
    Feuille de route
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Réseau Ferroviaire', 'Ligne', $planning->userRailwayLigne->railwayLigne->type->name.' '.$planning->number_travel)"
        :alert-feature="true" />
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
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">&nbsp;</h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-pills nav-pills-custom" role="tablist">
                            <li class="nav-item">
                                <a href="#screen" class="nav-link border-0 bg-light bg-active-primary active" data-bs-toggle="tab">
                                    Ecran
                                </a>
                            </li>
                            <li class="nav-item">
                                <a href="#table" class="nav-link border-0 bg-light bg-active-primary" data-bs-toggle="tab">
                                    Tableau
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="screen" role="tabpanel">
                            @livewire('game.core.screen.ecran', ["planning" => $planning])
                        </div>
                        <div class="tab-pane fade" id="table" role="tabpanel">
                            Tableau
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

