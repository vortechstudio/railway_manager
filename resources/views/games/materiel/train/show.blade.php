@extends('layouts.app')

@section("title")
    Détail d'une rame
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Gestion du matériel', 'Gestion des rames', "Détail d'une rame"],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.engine-menu />
            <div class="d-flex justify-content-center align-items-center bg-gray-100 rounded-3 p-5 mb-10">
                <ul class="nav nav-pills nav-pills-custom">
                    <li class="nav-item me-3 me-lg-6" role="presentation">
                        <a href="#details" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary text-active-primary flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px active">
                            <i class="fa-solid fa-eye text-muted  fs-3x" data-bs-toggle="tooltip" data-bs-title="Détail d'une rame"></i>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item me-3 me-lg-6" role="presentation">
                        <a href="#assignation" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary text-active-primary flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px">
                            <i class="fa-solid fa-hand-point-down text-muted fs-3x" data-bs-toggle="tooltip" data-bs-title="Assignation"></i>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item me-3 me-lg-6" role="presentation">
                        <a href="#configuration" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary text-active-primary flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px">
                            <i class="fa-solid fa-cogs text-muted fs-3x" data-bs-toggle="tooltip" data-bs-title="Reconfiguration"></i>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item me-3 me-lg-6" role="presentation">
                        <a href="#sell" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-danger text-active-danger flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px">
                            <i class="fa-solid fa-shopping-cart text-muted fs-3x" data-bs-toggle="tooltip" data-bs-title="Vendre une rame"></i>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-danger"></span>
                        </a>
                    </li>
                    <li class="nav-item me-3 me-lg-6" role="presentation">
                        <a href="#trajets" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary text-active-primary flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px">
                            <i class="fa-solid fa-route text-muted fs-3x" data-bs-toggle="tooltip" data-bs-title="Liste des trajets"></i>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                        </a>
                    </li>
                    <li class="nav-item me-3 me-lg-6" role="presentation">
                        <a href="#incidents" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-warning text-active-warning flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px">
                            <i class="fa-solid fa-exclamation-triangle text-muted fs-3x" data-bs-toggle="tooltip" data-bs-title="Liste des incidents"></i>
                            <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-warning"></span>
                        </a>
                    </li>
                </ul>
            </div>
            <div class="tab-content">
                <div class="tab-pane fade active show" id="details" role="tabpanel">
                    @livewire('game.engine.engine-detail', ['engine' => $engine])
                </div>
                <div class="tab-pane fade" id="assignation" role="tabpanel">
                    @if($engine->status->value != 'free')
                        <x-base.is-null
                            text="Cette rame est actuellement utiliser sur le reseaux" />
                    @else
                        @livewire('game.engine.engine-assign', ['engine' => $engine])
                    @endif
                </div>
                <div class="tab-pane fade" id="configuration" role="tabpanel">
                    @livewire('game.engine.engine-config-tab', ['engine' => $engine])
                </div>
                <div class="tab-pane fade" id="sell" role="tabpanel">
                    @livewire('game.engine.engine-sell-tab', ['engine' => $engine])
                </div>
                <div class="tab-pane fade" id="trajets" role="tabpanel">
                    @livewire('game.planning.planning-list-by-date', ['type' => 'engine', 'engine' => $engine])
                </div>
                <div class="tab-pane fade" id="incidents" role="tabpanel">
                    @livewire('game.engine.incident-list', ['type' => 'engine', 'engine' => $engine])
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush

