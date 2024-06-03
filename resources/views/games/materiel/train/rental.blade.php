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
            @livewire('game.engine.engine-rental-list')
        </div>
    </div>
@endsection

@push('scripts')
@endpush

