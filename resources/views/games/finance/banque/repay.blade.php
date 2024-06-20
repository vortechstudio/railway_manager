@extends('layouts.app')

@section("title")
    Emprunt N° {{ $emprunt->number }}
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Finance', 'Services Bancaires', $emprunt->railwayBanque->name, 'Emprunt N°'.$emprunt->number],
        "alertFeature" => true,
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.finance-menu title="Emprunt N°{{ $emprunt->number }}" />
            <div class="card shadow-sm mb-2">
                <div class="card-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-2 mb-5">
                            <div class="symbol symbol-150px">
                                <div class="symbol-label">
                                    <img src="{{ $emprunt->railwayBanque->image }}" class="w-90 img-fluid" alt="">
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-10 mb-5">
                            <div class="d-flex flex-column mb-2">
                                <span class="fw-bolder text-gray-300 fs-3hx">{{ $emprunt->railwayBanque->name }}</span>
                                <span>{{ $emprunt->railwayBanque->description }}</span>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="d-flex flex-column mb-5">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>Taux d'intérêt</span>
                                            <span class="fw-bold">{{ $emprunt->railwayBanque->latest_flux }} %</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>Emprunt Express</span>
                                            <div class="fw-bold">{{ Helpers::eur($emprunt->railwayBanque->userRailwayEmprunts()->where('user_railway_id', auth()->user()->railway->id)->where('type_emprunt', 'express')->sum('amount_emprunt')) }}</div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @livewire('game.finance.bank-form-repay', ['emprunt' => $emprunt])
        </div>
    </div>
@endsection

@push('scripts')

@endpush

