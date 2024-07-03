@extends('layouts.app')

@section("title")
    Souscription d'un Prêt Bancaire
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Finance', 'Services Bancaires', 'Souscription d\'un Prêt Bancaire'],
        "alertFeature" => true,
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.finance-menu title="Souscription d'un Prêt Bancaire" />
            @livewire('game.finance.bank-subscribe-form')
        </div>
    </div>
@endsection

@push('scripts')

@endpush

