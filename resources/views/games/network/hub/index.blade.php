@extends('layouts.app')

@section("title")
    Détail d'un Hub
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Réseau Ferroviaire', 'Hub', $hub->railwayHub->gare->name)"
        :alert-feature="true" />
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
                    <livewire:game.core.map type="lignes" :user_hub_id="$hub->id" />
                    <livewire:game.network.ligne-list type="hub" :hub="$hub" />
                </div>
                <div class="tab-pane fade" id="rames" role="tabpanel">
                    <livewire:game.engine.engine-list type="hub" :hub="$hub" />
                </div>
                <div class="tab-pane fade" id="travels" role="tabpanel">
                    <livewire:game.planning.planning-list-by-date type="hub" :hub="$hub" />
                </div>
            </div>
        </div>
    </div>
@endsection

