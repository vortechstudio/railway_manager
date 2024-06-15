@extends('layouts.app')

@section("title")
    Infrastructure
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Recherche & Développement', 'Infrastructure'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <div class="card shadow-sm" x-data="{card_title: 'Amélioration de Hub'}">
                <div class="card-header">
                    <h3 class="card-title" x-text="card_title"></h3>
                    <div class="card-toolbar">
                        <ul class="nav nav-pills nav-pills-custom nav-tabs" role="tablist">
                            <li class="nav-item" role="presentation">
                                <a href="#hubs" x-on:click="card_title = 'Amélioration de Hub'" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden p-5 active" data-bs-toggle="pill" role="tab">
                                    <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Hubs</span>
                                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                </a>
                            </li>
                            <li class="nav-item" role="presentation">
                                <a href="#lignes" x-on:click="card_title = 'Amélioration de Ligne'" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary flex-column overflow-hidden p-5" data-bs-toggle="pill" role="tab">
                                    <span class="nav-text text-gray-800 fw-bold fs-6 lh-1">Lignes</span>
                                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="card-body h-400px scroll">
                    <div class="tab-content">
                        <div class="tab-pane fade show active" id="hubs" role="tabpanel">
                            @foreach(auth()->user()->userRailwayHub as $hub)
                                @livewire('game.research.research-infra-hub-card', ['hub' => $hub])
                            @endforeach
                        </div>
                        <div class="tab-pane fade" id="lignes" role="tabpanel">
                            @foreach(auth()->user()->userRailwayLigne as $ligne)
                                @livewire('game.research.research-infra-ligne-card', ['ligne' => $ligne])
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush

