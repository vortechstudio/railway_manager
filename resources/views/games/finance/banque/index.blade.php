@extends('layouts.app')

@section("title")
    Services Bancaires
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Finance', 'Services Bancaires'],
        "alertFeature" => true,
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.finance-menu title="Liste des banques" />
            @livewire('game.finance.bank-list')
        </div>
    </div>
@endsection

@push('scripts')

@endpush

