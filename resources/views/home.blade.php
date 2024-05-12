@extends('layouts.app')

@section("title")
    Tableau de Bord
@endsection

@section("toolbar")
    <x-base.toolbar
        :breads="array('Tableau de Bord')" />
@endsection

@section("content")
    <div id="kt_app_content" class="app-content">
        <div class="row">
            <div class="col-sm-12 col-lg-6 mb-5">
                <livewire:widget.dashboard-agenda />
            </div>
            <div class="col-sm-12 col-lg-6 mb-5">
                <livewire:widget.dashboard-news />
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-4 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">SITUATION DE VOTRE COMPAGNIE (J-1)</h3>
                    </div>
                    <div class="card-body">
                        <div class="d-flex flex-row justify-content-between p-3 bg-gray-300 rounded-top-1">
                            <span class="fw-bold">Chiffre d'affaire</span>
                            <span>0,00 €</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between p-3 bg-gray-300">
                            <span class="fw-bold">Coût des trajets</span>
                            <span>0,00 €</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between p-3 bg-gray-300">
                            <span class="fw-bold">Résulat des trajets</span>
                            <span>0,00 €</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between p-3 bg-gray-300">
                            <span class="fw-bold">Remboursement des emprunts</span>
                            <span>0,00 €</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between p-3 bg-gray-300">
                            <span class="fw-bold">Coût des locations</span>
                            <span>0,00 €</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between p-3 bg-gray-300">
                            <span class="fw-bold">Trésorerie structurelle</span>
                            <span>0,00 €</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between p-3 bg-gray-300 rounded-bottom-1">
                            <span class="fw-bold">Investissement R&D</span>
                            <span>0,00 €</span>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">ÉVOLUTION DE VOS RÉSULTATS</h3>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-4 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">ÉVOLUTION DES INCIDENTS</h3>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-sm-12 col-lg-6 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-blue-800 text-white">
                        <h3 class="card-title">Prochains Départ</h3>
                        <div class="card-toolbar">
                        </div>
                    </div>
                    <div class="card-body bg-blue-700 p-0 m-0">
                        <div class="d-flex align-items-center p-3 gap-5 bg-white shadow-lg mb-2">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <span class="fs-2 fw-bolder text-blue-800">12:00</span>
                                <div class="d-flex align-items-center rounded-3 border border-primary p-1">
                                    <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                    <span class="fs-4 text-blue-800 fw-semibold"> à l'heure</span>
                                </div>
                            </div>
                            <div class="d-flex flex-grow-1 justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <span class="fs-2hx text-blue-800 fw-bold">Nantes</span>
                                    <div class="d-flex align-items-center">
                                        <span class="text-green-300 fs-3 me-2">via</span>
                                        <span class="fs-2 text-blue-800">Montaigu</span>
                                        <span class="bullet bullet-dot bg-green-300 mx-1"></span>
                                        <span class="fs-2 text-blue-800">Clisson</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-grow-0 bg-green-300 align-items-center justify-content-center w-100px h-auto rounded-2 p-2">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="fs-3 text-blue-800">TER</span>
                                    <span class="fs-2 text-blue-800 fw-bold">897400</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center p-3 gap-5 bg-white shadow-lg mb-2">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <span class="fs-2 fw-bolder text-blue-800">12:00</span>
                                <div class="d-flex align-items-center rounded-3 border border-primary p-1">
                                    <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                    <span class="fs-4 text-blue-800 fw-semibold"> à l'heure</span>
                                </div>
                            </div>
                            <div class="d-flex flex-grow-1 justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <span class="fs-2hx text-blue-800 fw-bold">Nantes</span>
                                    <div class="d-flex align-items-center">
                                        <span class="text-green-300 fs-3 me-2">via</span>
                                        <span class="fs-2 text-blue-800">Montaigu</span>
                                        <span class="bullet bullet-dot bg-green-300 mx-1"></span>
                                        <span class="fs-2 text-blue-800">Clisson</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-grow-0 bg-green-300 align-items-center justify-content-center w-100px h-auto rounded-2 p-2">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="fs-3 text-blue-800">TER</span>
                                    <span class="fs-2 text-blue-800 fw-bold">897400</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-sm-12 col-lg-6 mb-5">
                <div class="card shadow-sm">
                    <div class="card-header bg-blue-800 text-white">
                        <h3 class="card-title">Prochains Arrivées</h3>
                        <div class="card-toolbar">
                        </div>
                    </div>
                    <div class="card-body bg-blue-700 p-0 m-0">
                        <div class="d-flex align-items-center p-3 gap-5 bg-white shadow-lg mb-2">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <span class="fs-2 fw-bolder text-blue-800">12:00</span>
                                <div class="d-flex align-items-center rounded-3 border border-primary p-1">
                                    <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                    <span class="fs-4 text-blue-800 fw-semibold"> à l'heure</span>
                                </div>
                            </div>
                            <div class="d-flex flex-grow-1 justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <span class="fs-2hx text-blue-800 fw-bold">Nantes</span>
                                    <div class="d-flex align-items-center">
                                        <span class="text-green-300 fs-3 me-2">via</span>
                                        <span class="fs-2 text-blue-800">Montaigu</span>
                                        <span class="bullet bullet-dot bg-green-300 mx-1"></span>
                                        <span class="fs-2 text-blue-800">Clisson</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-grow-0 bg-green-300 align-items-center justify-content-center w-100px h-auto rounded-2 p-2">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="fs-3 text-blue-800">TER</span>
                                    <span class="fs-2 text-blue-800 fw-bold">897400</span>
                                </div>
                            </div>
                        </div>
                        <div class="d-flex align-items-center p-3 gap-5 bg-white shadow-lg mb-2">
                            <div class="d-flex flex-column justify-content-center align-items-center">
                                <span class="fs-2 fw-bolder text-blue-800">12:00</span>
                                <div class="d-flex align-items-center rounded-3 border border-primary p-1">
                                    <i class="fa-solid fa-clock-four text-blue-800 me-2 fs-3"></i>
                                    <span class="fs-4 text-blue-800 fw-semibold"> à l'heure</span>
                                </div>
                            </div>
                            <div class="d-flex flex-grow-1 justify-content-between align-items-center">
                                <div class="d-flex flex-column">
                                    <span class="fs-2hx text-blue-800 fw-bold">Nantes</span>
                                    <div class="d-flex align-items-center">
                                        <span class="text-green-300 fs-3 me-2">via</span>
                                        <span class="fs-2 text-blue-800">Montaigu</span>
                                        <span class="bullet bullet-dot bg-green-300 mx-1"></span>
                                        <span class="fs-2 text-blue-800">Clisson</span>
                                    </div>
                                </div>
                            </div>
                            <div class="d-flex flex-grow-0 bg-green-300 align-items-center justify-content-center w-100px h-auto rounded-2 p-2">
                                <div class="d-flex flex-column align-items-center">
                                    <span class="fs-3 text-blue-800">TER</span>
                                    <span class="fs-2 text-blue-800 fw-bold">897400</span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

