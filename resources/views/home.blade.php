@extends('layouts.app')

@section("title")
    Tableau de Bord
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Tableau de Bord'],
    ])
@endsection

@section("content")
    <div class="container-xxl">
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
                            <h3 class="card-title fs-5">
                                <img src="{{ Storage::url('icons/railway/hq.png') }}" alt="Hub" class="w-20px h-20px me-3">
                                SITUATION DE VOTRE COMPAGNIE (J-1)
                            </h3>
                        </div>
                        <div class="card-body h-250px scroll">
                            <div class="d-flex flex-row justify-content-between p-3 bg-gray-300 rounded-top-1">
                                <span class="fw-bold">Chiffre d'affaire</span>
                                <span>{{ Helpers::eur((new \App\Services\Models\User\Railway\UserRailwayCompanyAction(auth()->user()->railway_company))->getCA(now()->subDay(), now()->subDay())) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between p-3 bg-gray-300">
                                <span class="fw-bold">Coût des trajets</span>
                                <span>{{ Helpers::eur((new \App\Services\Models\User\Railway\UserRailwayCompanyAction(auth()->user()->railway_company))->getCoastTravel(now()->subDay(), now()->subDay())) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between p-3 bg-gray-300">
                                <span class="fw-bold">Résulat des trajets</span>
                                <span>{{ Helpers::eur((new \App\Services\Models\User\Railway\UserRailwayCompanyAction(auth()->user()->railway_company))->getResultat(now()->subDay(), now()->subDay())) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between p-3 bg-gray-300">
                                <span class="fw-bold">Remboursement des emprunts</span>
                                <span>{{ Helpers::eur((new \App\Services\Models\User\Railway\UserRailwayCompanyAction(auth()->user()->railway_company))->getRembEmprunt(now()->subDay(), now()->subDay())) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between p-3 bg-gray-300">
                                <span class="fw-bold">Coût des locations</span>
                                <span>{{ Helpers::eur((new \App\Services\Models\User\Railway\UserRailwayCompanyAction(auth()->user()->railway_company))->getLocationMateriel(now()->subDay(), now()->subDay())) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between p-3 bg-gray-300">
                                <span class="fw-bold">Trésorerie structurelle</span>
                                <span>{{ Helpers::eur((new \App\Services\Models\User\Railway\UserRailwayCompanyAction(auth()->user()->railway_company))->getTresorerieStructurel(now()->subDay(), now()->subDay())) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between p-3 bg-gray-300 rounded-bottom-1">
                                <span class="fw-bold">Investissement R&D</span>
                                <span>{{ Helpers::eur(auth()->user()->railway->research) }}</span>
                            </div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex flex-center">
                                <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">Comptabilité Générale <i
                                        class="ki-outline ki-arrow-right fs-5"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title fs-5">
                                <img src="{{ Storage::url('icons/railway/bank.png') }}" alt="Hub" class="w-20px h-20px me-3">
                                EMPRUNTS, PROCHAINES ÉCHÉANCES
                            </h3>
                        </div>
                        <div class="card-body scroll h-250px">
                            <table class="table">
                                <tbody>
                                <tr>
                                    <td>Minibank</td>
                                    <td class="text-danger text-end">1 852 000 €</td>
                                    <td class="text-end">24/10/2023</td>
                                </tr>
                                </tbody>
                            </table>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex flex-center">
                                <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">Comptabilité Générale <i
                                        class="ki-outline ki-arrow-right fs-5"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-4 mb-5">
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title fs-5">
                                <img src="{{ Storage::url('icons/railway/financial.png') }}" alt="Hub" class="w-20px h-20px me-3">
                                ÉVOLUTION DE VOS RÉSULTATS
                            </h3>
                        </div>
                        <div class="card-body  h-250px">
                            <div id="evoRsultatChart" style="height: 200px"></div>
                        </div>
                        <div class="card-footer">
                            <div class="d-flex flex-center">
                                <a href="#" class="btn btn-color-gray-600 btn-active-color-primary">Comptabilité Générale <i
                                        class="ki-outline ki-arrow-right fs-5"></i></a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @livewire('game.core.screen-departure')
        </div>
    </div>
@endsection

