@extends('layouts.app')

@section("title")
    Recherche & Développement
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Recherche & Développement'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            @livewire('game.research.research-budget')
            @livewire('game.research.research-tree')
        </div>
    </div>
@endsection

@push('scripts')

@endpush

