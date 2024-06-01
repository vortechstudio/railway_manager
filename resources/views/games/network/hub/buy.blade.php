@extends('layouts.app')

@section("title")
    Achat d'un Hub
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Réseau Ferroviaire', 'hub', "Achat d'un hub"],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <div class="d-flex flex-row align-items-center">
                    <div class="symbol symbol-70px symbol-circle me-5">
                        <img src="{{ Storage::url('icons/railway/hub_checkout.png') }}" alt="">
                    </div>
                    <span class="fw-bold fs-2">Achat d'un Hub</span>
                </div>
                <x-game.network-menu />
            </div>
            <div class="card shadow-sm my-5">
                <div class="card-body">
                    @livewire('game.core.map', ["type" => "hubs", "hubs" => $hubs])
                </div>
            </div>
            @livewire('game.network.hub-checkout', ['hubs' => $hubs])
        </div>
    </div>
@endsection

