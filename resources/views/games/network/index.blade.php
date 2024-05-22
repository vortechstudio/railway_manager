@extends('layouts.app')

@section("title")
    Réseau
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Réseau Ferroviaire')"
        :alert-feature="true" />
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.network-menu />
            <div class="card shadow-sm mb-5">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-9 mb-5">
                            <div id="map"></div>
                        </div>
                        <div class="col-sm-12 col-lg-3 mb-5">
                            <h3 class="card-title">Filtres</h3>

                        </div>
                    </div>
                </div>
            </div>

            <div class="card shadow-sm">
                <div class="card-body">
                    <livewire:game.network.hub-list />
                    <livewire:game.network.ligne-list />
                </div>
            </div>
        </div>
    </div>
@endsection

