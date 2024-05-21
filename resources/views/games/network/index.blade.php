@extends('layouts.app')

@section("title")
    Réseau
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Réseau Ferroviaire')" />
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
                    <div class="d-flex flex-column bg-white p-5 mb-5 rounded-2">
                        <div class="d-flex flex-row justify-content-between align-items-center border border-bottom-2 border-top-0 border-left-0 border-right-0 pb-1 mb-5">
                            <div class="d-flex align-items-center">
                                <span class="badge bagde-circle badge-primary text-white me-2">Ligne</span>
                                <span class="fw-bold fs-3">Nantes <-> Angers Saint-Laud</span>
                            </div>
                            <button class="btn btn-flex bg-blue-600 bg-hover-primary">
                                <span class="symbol symbol-35px me-2">
                                    <img src="{{ Storage::url('icons/railway/ligne.png') }}" alt="">
                                </span>
                                <span class="text-white">Détail de la ligne</span>
                            </button>
                        </div>
                        <div class="d-flex flex-row align-items-center">
                            <i class="fa-solid fa-circle-arrow-right text-orange-600 fs-2 me-5"></i>
                            <div class="d-flex align-items-center me-5">
                                <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                                <span class="me-2">Distance: </span>
                                <span class="fw-bold">81 Km</span>
                            </div>
                            <div class="d-flex align-items-center me-5">
                                <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                                <span class="me-2">Offre restante J-1: </span>
                                <span class="fw-bold">253 P</span>
                            </div>
                            <div class="d-flex align-items-center me-5">
                                <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                                <span class="me-2">Chiffre d'affaires: </span>
                                <span class="fw-bold">285 000 €</span>
                            </div>
                            <div class="d-flex align-items-center me-5">
                                <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                                <span class="me-2">Bénéfices: </span>
                                <span class="fw-bold">279 320 €</span>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

