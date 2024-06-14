<div>
    @if(count($deliveries) > 0)
        @foreach($deliveries as $delivery)
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex flex-column">
                        <div class="d-flex justify-content-between">
                            <span>{{ $delivery->designation }}</span>
                            <div class="d-flex align-items-center">
                                <i class="fa-solid fa-clock text-warning fs-3 me-2"></i>
                                <span data-countdown-delivery="{{ $delivery->end_at->timestamp }}"></span>
                            </div>
                        </div>
                        <div class="h-8px mx-3 w-100 bg-black bg-opacity-50 rounded mb-2">
                            <div class="bg-yellow-600 bg-striped rounded h-8px" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-total-time="{{ $delivery->diff_in_second }}"></div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    @else
        <div class="d-flex flex-column">
            <span class="fs-4 fw-semibold">AUCUNE RECHERCHE EN COURS DE DÉVELOPPEMENT</span>
            <p>Pour développer une recherche, il vous suffit de cliquer sur la vignette correspondante.</p>
            <p>Passez votre curseur au dessus de la vignette pour connaître le prix d'une recherche et l'effet qu'elle aura sur le développement de votre compagnie.</p>
        </div>
    @endif
</div>

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
