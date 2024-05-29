@extends('layouts.app')

@section("title")
    Achat d'une ligne
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Réseau Ferroviaire', 'Ligne', 'Achat d\'une Ligne')"
        :alert-feature="true" />
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <div class="d-flex flex-row justify-content-between align-items-center">
                <div class="d-flex flex-row align-items-center">
                    <div class="symbol symbol-70px symbol-circle me-5">
                        <img src="{{ Storage::url('icons/railway/ligne_checkout.png') }}" alt="">
                    </div>
                    <span class="fw-bold fs-2">Achat d'une ligne</span>
                </div>
                <x-game.network-menu />
            </div>
            @livewire('game.network.ligne-checkout', ["hubs" => $hubs])
        </div>
    </div>
@endsection

