@extends('layouts.app')

@section("title")
    Réseau
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Réseau Ferroviaire'],
        "alertFeature" => true
    ])
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
                            @livewire('game.core.delivery-list')
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

