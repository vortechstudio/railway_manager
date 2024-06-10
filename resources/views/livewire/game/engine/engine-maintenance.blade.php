<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <div class="symbol symbol-30px symbol-circle me-3">
                    <img src="{{ Storage::url('icons/railway/maintenance.png') }}" alt="">
                </div>
                <span>Réparations / Maintenance</span>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center gap-5 mb-10">
                <a href="{{ route('train.index') }}" class="btn btn-primary">Réparation individuelle</a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#repair">Réparation groupée</button>
            </div>
            @if(count($engineTechnicentres) == 0)
                <x-base.is-null text="Aucune maintenances programmées actuellement" />
            @else
                <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                    <thead>
                        <tr>
                            <th>Matériel</th>
                            <th>Type de maintenance</th>
                            <th>Etat</th>
                            <th></th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($engineTechnicentres as $engine)
                            <tr>
                                <td>
                                    <div class="d-flex align-items-center">
                                        <img src="{{ $engine->userRailwayEngine->railwayEngine->getFirstImage($engine->userRailwayEngine->railwayEngine->id) }}" class="w-70px img-fluid me-3" alt="">
                                        <div class="d-flex flex-column">
                                            <span>{{ $engine->userRailwayEngine->railwayEngine->name }}</span>
                                            <span>{{ $engine->userRailwayEngine->railwayEngine->type_transport->name }} {{ $engine->userRailwayEngine->number }}</span>
                                        </div>
                                    </div>
                                </td>
                                <td>{!! $engine->type_label !!}</td>
                                <td>
                                    <div class="d-flex flex-column">
                                        <div class="h-8px mx-3 w-100 bg-black bg-opacity-50 rounded mb-2">
                                            <div class="bg-yellow-600 bg-striped rounded h-8px" role="progressbar" style="width: 50%" aria-valuenow="50" aria-valuemin="0" aria-valuemax="100" data-total-time="{{ $engine->diff_in_second }}"></div>
                                        </div>
                                        <div class="d-flex align-items-center">
                                            <i class="fa-solid fa-clock text-warning fs-3 me-2"></i>
                                            <span data-ago="{{ $engine->end_at->timestamp }}"></span>
                                        </div>
                                    </div>
                                </td>
                                <td>
                                    <button wire:click="accelerate({{ $engine->id }})" class="btn btn-sm btn-primary w-100">Accélérer la maintenance</button>
                                </td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            @endif
        </div>
    </div>
    @livewire('game.engine.engine-maintenance-group-form')
</div>

@push('scripts')
    <x-base.close-modal />
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
