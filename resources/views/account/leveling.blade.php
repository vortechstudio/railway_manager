@extends('layouts.app')

@section("title")
    Récompense de niveau
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Compte', 'Récompense de niveau'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content animated-background h-100">
            @livewire('account.leveling-table')
        </div>
    </div>
@endsection

