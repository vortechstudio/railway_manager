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
            <x-game.network-menu />
            <div class="d-flex flex-row justify-content-between align-items-center rounded-1 bg-gray-800 text-white gap-3 mb-5 p-2">
                <div class="d-flex align-items-center">
                    <div class="symbol symbol-70px symbol-circle bg-gray-400 me-2">
                        <img src="{{ Storage::url('icons/railway/ligne.png') }}" alt="">
                    </div>
                    <span class="fw-bold">Détail d'une ligne</span>
                </div>
                <ul class="nav nav-pills nav-pills-custom " role="tablist">
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Détail de la ligne">
                        <a href="#detail" class="nav-link active border-0 bg-active-light text-active-dark" data-bs-toggle="tab">
                            <i class="fa-solid fa-search text-white fs-2x"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Liste des Trajets">
                        <a href="#travels" class="nav-link border-0 bg-active-light text-active-dark" data-bs-toggle="tab">
                            <i class="fa-solid fa-route text-white fs-2x"></i>
                        </a>
                    </li>
                    <li class="nav-item" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Vendre la ligne">
                        <a href="#selling" class="nav-link border-0 bg-active-danger text-active-light" data-bs-toggle="tab">
                            <i class="fa-solid fa-shopping-cart text-white fs-2x"></i>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade show active" id="detail" role="tabpanel">
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

