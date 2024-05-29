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
                            <div id="map">
                                @livewire('game.core.map')
                            </div>
                        </div>
                        <div class="col-sm-12 col-lg-3 mb-5">
                            <h3 class="card-title">Filtres</h3>
                            @if($user->userRailwayDelivery()->get()->count() > 0)
                                <x-base.title title="Livraison en cours" />
                                @foreach($user->userRailwayDelivery()->get() as $delivery)
                                    <div class="card shadow-sm">
                                        <div class="card-body">
                                            <div class="d-flex flex-column">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <div class="d-flex align-items-center">
                                                        <div class="symbol symbol-50 symbol-circle me-3">
                                                            <img src="{{ $delivery->icon_type }}" alt="">
                                                        </div>
                                                        <span class="fw-bold">{{ $delivery->designation }}</span>
                                                    </div>
                                                    <div class="d-flex align-items-center">
                                                        <i class="fa-solid fa-clock text-warning fs-3 me-2"></i>
                                                        <span data-countdown-delivery="{{ $delivery->end_at->timestamp }}"></span>
                                                    </div>
                                                </div>
                                                <div class="h-8px mx-3 w-100 bg-black bg-opacity-50 rounded">
                                                    <div class="bg-yellow-600 bg-striped rounded h-8px" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-total-time="{{ $delivery->diff_in_second }}"></div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            @endif
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

@push('scripts')
    <script>
        $(document).ready(function () {
            setInterval(function () {
                $('span[data-countdown-delivery]').each(function () {
                    let endAtTimestamp = $(this).data('countdown-delivery')
                    let nowTimestamp = Math.floor($.now() / 1000);
                    let diffSecs = endAtTimestamp - nowTimestamp;

                    if(diffSecs <= 0) {
                        $(this).closest('.card').hide()
                    } else {
                        let displayTime = diffSecs > 60 ? Math.floor(diffSecs / 60) + ' min' : diffSecs + ' secondes';
                        $(this).text(displayTime)

                        let progressBar = $(this).closest(".card").find(".bg-black").children();
                        console.log(progressBar)

                        if(progressBar.length) {
                            let totalTimeSecs = progressBar.data('total-time');
                            let elapsedPercentage = 100 - Math.floor((diffSecs / totalTimeSecs) * 100)
                            progressBar.css('width', elapsedPercentage + '%');
                            progressBar.attr('aria-valuenow', elapsedPercentage)
                        }
                    }
                })
            }, 1000);
        })
    </script>
@endpush

