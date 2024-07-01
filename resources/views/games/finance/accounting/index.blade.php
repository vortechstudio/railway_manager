@extends('layouts.app')

@section("title")
    Comptabilité générale
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Finance', 'Comptabilité générale'],
        "alertFeature" => true,
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.finance-menu title="Comptabilité générale" />
            @livewire('game.finance.resume-card')
            @livewire('game.finance.compta-livre')
        </div>
    </div>
@endsection

@push('scripts')

@endpush

