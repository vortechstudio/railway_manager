<div>
    <div class="card shadow-sm mb-2">
        <div class="card-body">
            <div class="row">
                <div class="col-sm-12 col-lg-2 mb-5">
                    <div class="symbol symbol-150px">
                        <div class="symbol-label">
                            <img src="{{ $banque->image }}" class="w-90 img-fluid" alt="">
                        </div>
                    </div>
                </div>
                <div class="col-sm-12 col-lg-10 mb-5">
                    <div class="d-flex flex-column mb-2">
                        <div class="d-flex justify-content-between align-items-center">
                            <span class="fw-bolder text-gray-300 fs-3hx">{{ $banque->name }}</span>
                            @if($banque->is_unlocked)
                                <div class="gap-2">
                                    <a href="{{ route('finance.bank.show', $banque->id) }}" class="btn btn-sm btn-warning">
                                        <i class="fa-solid fa-list-check fs-2 me-2"></i> Détail des Emprunts
                                    </a>
                                    <a href="{{ route('finance.bank.subscribe') }}" class="btn btn-sm btn-primary">
                                        <i class="fa-solid fa-briefcase-clock fs-2 me-2"></i> Nouvelle Emprunt
                                    </a>
                                </div>
                            @endif
                        </div>
                        @if($banque->is_unlocked)
                            <div class="d-flex flex-column mb-5">
                                <span class="fw-bold">Effectuer une opération</span>
                                <div class="separator"></div>
                                <div class="d-flex align-items-center gap-2">
                                    <a href="" class="btn btn-flush text-hover-primary" data-bs-toggle="tooltip"
                                       title="Détail des emprunts"><i class="fa-solid fa-list-check fs-2"></i> </a>
                                    <button  data-id="express" class="btn btn-flush text-hover-primary" data-bs-toggle="tooltip"
                                       title="Emprunt Express"><i class="fa-solid fa-briefcase-clock fs-2"></i> </button>
                                    <button data-id="market" class="btn btn-flush text-hover-primary" data-bs-toggle="tooltip"
                                       title="Emprunt sur le marché financier"><i class="fa-solid fa-chart-line fs-2"></i>
                                    </button>
                                </div>
                            </div>
                        @else
                            <span class="text-red-400 fw-bold">{{ $banque->is_unlocked_text }}</span>
                        @endif
                        <span>{{ $banque->description }}</span>
                    </div>
                    <div class="row">
                        <div class="col-sm-12 col-lg-6">
                            <div class="d-flex flex-column mb-5">
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Taux d'intérêt</span>
                                    <div class="d-flex w-50 me-3">
                                        <div class="h-8px mx-3 w-100 bg-primary bg-opacity-50 rounded">
                                            <div class="bg-primary rounded h-8px" role="progressbar"
                                                 style="width: {{ $banque->interest_percentage }}%;"
                                                 aria-valuenow="{{ $banque->interest_percentage }}" aria-valuemin="0"
                                                 aria-valuemax="100"></div>
                                        </div>
                                    </div>
                                    <span class="fw-bold">{{ $banque->latest_flux }} %</span>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Emprunt Express possible</span>
                                    <div class="fw-bold">{{ Helpers::eur($banque->express_base) }}</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Emprunt sur les marché possible</span>
                                    <div class="fw-bold">{{ Helpers::eur($banque->public_base) }}</div>
                                </div>
                            </div>
                            <div class="d-flex flex-column">
                                <span class="fw-bold mb-1">Vos emprunts en cours</span>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Emprunt Express</span>
                                    <div class="fw-bold">{{ Helpers::eur($empruntExpress) }}</div>
                                </div>
                                <div class="d-flex justify-content-between align-items-center mb-2">
                                    <span>Sur le marché financier</span>
                                    <div class="fw-bold">{{ Helpers::eur($empruntMarket) }}</div>
                                </div>
                            </div>
                        </div>
                        <div class="order-sm-last col-sm-12 col-lg-6">
                            <div id="chartTaux" class="chartsTaux_{{ $banque->id }}" style="height: 250px;"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @livewire('game.finance.bank-form-express', ['banque' => $banque])
    @livewire('game.finance.bank-form-market', ['banque' => $banque])
</div>
@push('scripts')
    @php
        $dataX = collect();
        for($d = 0; $d <= 8; $d++) {
            $dataX->add(now()->subDays(8)->addDays($d)->format('d.m'));
        }

        $dataY = collect();
        for ($y = 0; $y <= 8; $y++) {
            $query = $banque->fluxes()->whereDate('date', now()->subDays(8)->addDays($y));
            $dataY->add($query->exists() ? $query->first()->interest : 0);
        }
    @endphp
    <script src="https://cdn.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>
    <script>
        document.querySelectorAll('[data-id="express"]').forEach(btn => {
            btn.addEventListener('click', e => {
                let expressModal = new bootstrap.Modal(document.querySelector('#express'))
                expressModal.show()
            })
        })

        document.querySelectorAll('[data-id="market"]').forEach(btn => {
            btn.addEventListener('click', e => {
                let expressModal = new bootstrap.Modal(document.querySelector('#market'))
                expressModal.show()
            })
        })
    </script>
    <script>
        let chartDom_{{ $banque->id }} = document.querySelector('.chartsTaux_{{ $banque->id }}')
        let chart_{{ $banque->id }} = echarts.init(chartDom_{{ $banque->id }});
        let options_{{ $banque->id }};

        options_{{ $banque->id }} = {
            legend: {
                data: ['Taux'],
                left: 'left',
                textStyle: {
                    color: '#000'
                }
            },
            tooltip: {
                trigger: 'axis',
                formatter: '{b}<br>Taux: {c}'
            },
            xAxis: {
                type: 'category',
                data: @json($dataX)
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    data: @json($dataY),
                    type: 'line',
                    name: 'Taux',
                    symbolSize: 10,
                    symbol: 'circle',
                    areaStyle: {}
                }
            ]
        }

        if (options_{{ $banque->id }} && typeof options_{{ $banque->id }} === 'object') {
            chart_{{ $banque->id }}.setOption(options_{{ $banque->id }});
        }

        window.addEventListener('resize', chart_{{ $banque->id }}.resize);
    </script>
@endpush
