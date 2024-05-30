@extends('layouts.app')

@section("title")
    Achat d'un matériel roulant
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Gestion du matériel', 'Achat d\'un matériel roulant')"
        :alert-feature="true" />
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            @livewire('game.engine.engine-sell-list')
        </div>
    </div>
@endsection

@push('scripts')
@endpush

