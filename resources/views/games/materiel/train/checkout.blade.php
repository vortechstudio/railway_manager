@extends('layouts.app')

@section("title")
    Achat d'un matériel roulant
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Gestion du matériel', 'Achat d\'un matériel roulant'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.engine-menu />
            @livewire('game.engine.engine-sell-list')
        </div>
    </div>
@endsection

@push('scripts')
@endpush

