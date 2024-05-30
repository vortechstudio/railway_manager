@extends('layouts.app')

@section("title")
    Planification
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Réseau Ferroviaire', 'Planification'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.network-menu />
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">{{ now()->locale('fr_FR')->isoFormat('LL') }}</h3>
                </div>
                <div class="card-body">
                    @livewire('game.planning.planning-timeline')
                </div>
            </div>
        </div>
    </div>
@endsection

