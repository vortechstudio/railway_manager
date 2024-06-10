@extends('layouts.app')

@section("title")
    Technicentre
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Gestion du matériel', 'Technicentre'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.engine-menu />
            @livewire('gare.engine.incident-graph')
            <div class="row mb-10">
                <div class="col-6">
                    @livewire('gare.engine.engine-graph-usure')
                </div>
                <div class="col-6">
                    @livewire('gare.engine.engine-graph-ancien')
                </div>
            </div>
            @livewire('game.engine.engine-maintenance')
        </div>
    </div>
@endsection

@push('scripts')
@endpush

