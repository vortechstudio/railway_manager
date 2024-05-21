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
            <div class="d-flex flex-end justify-content-end align-items-center gap-3 mb-5">
                <a href="" class="btn btn-flush">
                    <span class="symbol symbol-40px symbol-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Planifier">
                        <img src="{{ Storage::url('icons/railway/planning.png') }}" alt="">
                    </span>
                </a>
                <a href="" class="btn btn-flush">
                    <span class="symbol symbol-40px symbol-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Acheter un hub">
                        <img src="{{ Storage::url('icons/railway/hub_checkout.png') }}" alt="">
                    </span>
                </a>
                <a href="" class="btn btn-flush">
                    <span class="symbol symbol-40px symbol-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Ouvrir une ligne">
                        <img src="{{ Storage::url('icons/railway/ligne_checkout.png') }}" alt="">
                    </span>
                </a>
                <a href="" class="btn btn-flush">
                    <span class="symbol symbol-40px symbol-circle" data-bs-toggle="tooltip" data-bs-placement="top" data-bs-title="Réseau ferroviaire">
                        <img src="{{ Storage::url('icons/railway/network.png') }}" alt="">
                    </span>
                </a>
            </div>
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

