<div class="mb-10">
    <div class="row rounded-3 p-5" style="background: url('{{ Storage::url("services/{$service->id}/game/wall/wall_technique.png") }}') center no-repeat; background-size: cover; backdrop-filter: blur(10px);">
        <div class="col-sm-12 col-lg-9 mb-5 bg-gray-200 bg-opacity-75 rounded-2 p-5">
            <div id="chartIncident" style="height: 300px"></div>
        </div>
        <div class="col-sm-12 col-lg-3 mb-5">
            <div class="d-flex flex-column justify-content-center align-items-center">
                <div class="d-flex flex-column bg-gray-900 bg-opacity-75 justify-content-center align-items-center p-2 mb-5">
                    <span class="fs-5 text-white text-center">MONTANT DES RÉPARATIONS IMPRÉVUES DEPUIS 24H</span>
                    <span class="fs-8 text-white text-center">{{ Helpers::eur($amountRepareDay) }}</span>
                </div>
                <button data-bs-toggle="modal" data-bs-target="#HistoryIncident" class="btn btn-lg btn-warning">Historique des incidents</button>
            </div>
        </div>
    </div>
    <div wire:ignore.self class="modal fade" tabindex="-1" id="HistoryIncident">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content">
                <div class="modal-header bg-warning bg-striped">
                    <h3 class="modal-title text-white">Historique des incident</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-warning ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1 text-danger"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    @livewire('game.engine.incident-list')
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <x-base.close-modal />
    @php
        $dataX = collect();
        for ($d=0; $d <= 30; $d++) {
            $dataX->add(now()->subDays(30)->addDays($d)->format('d/m/Y'));
        }

        $dataY = collect();
        for ($d=0; $d <= 30; $d++) {
            $query = auth()->user()->railway_incidents()->whereBetween('created_at', [now()->subDays(30)->addDays($d)->startOfDay(), now()->subDays(30)->addDays($d)->endOfDay()])
                ->count();
            $dataY->add($query);
        }
        $dataYAll = collect();
        for ($d=0; $d <= 30; $d++) {
            $query = \App\Models\Railway\Planning\RailwayIncident::whereBetween('created_at', [now()->subDays(30)->addDays($d)->startOfDay(), now()->subDays(30)->addDays($d)->endOfDay()])
                ->count();
            $dataYAll->add($query);
        }
    @endphp
    <script src="https://fastly.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>
    <script>
        let chartDom = document.getElementById('chartIncident')
        let chartIncident = echarts.init(chartDom, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });

        let app = {};
        let option;

        option = {
            legend: {
                data: ['Votre compagnie', 'Moyenne des joueurs de même rang'],
                left: 'left',
                textStyle: {
                    color: '#000'
                }
            },
            tooltip: {
                trigger: 'axis',
                formatter: 'Incident : {c}'
            },
            xAxis: {
                type: 'category',
                data: @json($dataX),
            },
            yAxis: {
                type: 'value'
            },
            series: [
                {
                    data: @json($dataY),
                    type: 'line',
                    name: 'Votre compagnie',
                    symbolSize: 10,
                    symbol: 'circle',
                    areaStyle: {}
                },
                {
                    data: @json($dataYAll),
                    type: 'line',
                    name: 'Moyenne des joueurs de même rang',
                    symbolSize: 10,
                    symbol: 'circle',
                    areaStyle: {}
                },
            ],
            textStyle: {
                color: '#000'
            }
        }

        if (option && typeof option === 'object') {
            chartIncident.setOption(option);
        }

        window.addEventListener('resize', chartIncident.resize);
    </script>
@endpush
