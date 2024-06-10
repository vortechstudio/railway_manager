<div class="bg-gray-300 bg-opacity-75 rounded-2 p-5">
    <div class="d-flex align-items-center">
        <i class="fa-solid fa-train fs-2 me-2"></i>
        <span class="text-uppercase fs-3 fw-semibold">Répartition des rames par usure</span>
    </div>
    @if($percent_graph_used > 0)
    <div class="d-flex bg-blue-100 rounded-2 mb-10 p-5">
        {{ $percent_graph_used }} % de vos rames sont usés ou très usés. Vous devriez les réparer rapidement.
    </div>
    @endif
    <div id="chartUsure" style="height: 300px"></div>
</div>

@push('scripts')
    @php
        $usure_basse = auth()->user()->railway_engines()->where('use_percent', '<=', 33)->count();
        $usure_forte = auth()->user()->railway_engines()->whereBetween('use_percent', [34,66])->count();
        $usure_extreme = auth()->user()->railway_engines()->where('use_percent', '>', 66)->count();

        $data = collect();
        $data->add(["value" => $usure_basse, "name" => "Usure Basse"]);
        $data->add(["value" => $usure_forte, "name" => "Usure Forte"]);
        $data->add(["value" => $usure_extreme, "name" => "Usure Extreme"]);

    @endphp
    <script src="https://fastly.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>
    <script>
        let chartDomUsure = document.getElementById('chartUsure')
        let chartUsure = echarts.init(chartDomUsure, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });

        let optionUsure;

        optionUsure = {
            tooltip: {
                trigger: 'item',
            },
            legend: {
                top: '5%',
                left: 'center'
            },
            series: [
                {
                    name: 'Train par usure',
                    type: 'pie',
                    radius: ['40%', '70%'],
                    avoidLabelOverlap: false,
                    itemStyle: {
                        borderRadius: 10,
                        borderColor: '#fff',
                        borderWidth: 2
                    },
                    label: {
                        show: false,
                        position: 'center'
                    },
                    emphasis: {
                        label: {
                            show: true,
                            fontSize: 40,
                            fontWeight: 'bold'
                        }
                    },
                    labelLine: {
                        show: false
                    },
                    data: @json($data)
                }
            ]
        }

        optionUsure && chartUsure.setOption(optionUsure);
    </script>
@endpush
