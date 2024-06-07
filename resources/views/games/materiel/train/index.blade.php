@extends('layouts.app')

@section("title")
    Gestion des rames
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Gestion du matériel', 'Gestion des rames'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.engine-menu />
            @livewire('game.engine.engine-list')
        </div>
    </div>
@endsection

@push('scripts')
@endpush

