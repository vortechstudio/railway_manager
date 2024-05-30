@extends('layouts.app')

@section("title")
    Achat d'un matériel roulant
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Gestion du matériel', 'Achat d\'un matériel roulant'],
        "alertFeature" => true
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.network-menu />
            <div class="card shadow-sm h-550px">
                <div class="card-body">
                    <div class="d-flex flex-row justify-content-center align-items-center p-5 mx-auto gap-5">
                        <a href="{{ route('train.checkout') }}" class="bgi-size-contain bgi-size-lg-auto bgi-no-repeat bgi-position-center card shadow-sm w-200px h-450px bg-hover-light-dark bg-hover-opacity-20 hover-scale" style="background: url('{{ Storage::url('services/'.$service->id.'/game/wall/checkout_engine_wall.jpg') }}')">
                            <div class="card-body">
                                <div class="d-flex flex-column justify-content-center align-items-center mx-auto h-100">
                                    <div class="symbol symbol-100px">
                                        <img src="{{ Storage::url('icons/railway/train_sell.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </a>
                        <a href="{{ route('train.rental') }}" class="bgi-size-contain bgi-size-lg-auto bgi-no-repeat bgi-position-center card shadow-sm w-200px h-450px bg-hover-light-dark bg-hover-opacity-20 hover-scale" style="background: url('{{ Storage::url('services/'.$service->id.'/game/wall/rent_engine_wall.jpg') }}')">
                            <div class="card-body">
                                <div class="d-flex flex-column justify-content-center align-items-center mx-auto h-100">
                                    <div class="symbol symbol-100px">
                                        <img src="{{ Storage::url('icons/railway/train_rent.png') }}" alt="">
                                    </div>
                                </div>
                            </div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
@endsection

@push('scripts')
@endpush

