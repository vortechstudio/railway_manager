@extends('layouts.app')

@section("title")
    Finance
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Finance'],
        "alertFeature" => true,
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.finance-menu title="Finance" />
            @livewire('game.finance.resume-card')
            <div class="d-flex flex-column">
                <div class="d-flex p-5 gap-3">
                    <div class="symbol symbol-150px">
                        <div class="symbol-label bg-indigo-400">
                            <img src="{{ Storage::url('icons/railway/bank.png') }}" alt="" class="w-125px img-fluid">
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="text-grey-400 fs-2tx mb-1">Banque</span>
                        <span class="fs-6 mb-1">
                            Accédez aux ressources banquières de Railway Manager pour demander à votre Banquier une aide financière pour la croissance de votre compagnie. Les Banques seront ravies de répondre à vos demandes.
                        </span>
                        <a href="{{ route('finance.bank.index') }}" class="btn btn-primary w-20">Entrer</a>
                    </div>
                </div>
                <div class="separator"></div>
                <div class="d-flex p-5 gap-3">
                    <div class="symbol symbol-150px">
                        <div class="symbol-label bg-amber-400">
                            <img src="{{ Storage::url('icons/railway/accounting.png') }}" alt="" class="w-125px img-fluid">
                        </div>
                    </div>
                    <div class="d-flex flex-column">
                        <span class="text-grey-400 fs-2tx mb-1">Comptabilité</span>
                        <span class="fs-6 mb-1">
                            Analysez chaque euro perçu et dépensé dans cette partie comptabilité. Plus rien ne vous échappera !
                        </span>
                        <a href="" class="btn bg-amber-600 w-20">Consulter</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')

@endpush

