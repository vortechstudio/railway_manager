@extends('layouts.app')

@section("title")
    Classement
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Compagnie', 'Classement'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.company-menu />
            @livewire('game.company.ranking-table')
        </div>
    </div>
@endsection
