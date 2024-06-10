<div class="bg-gray-300 bg-opacity-75 rounded-2 p-5">
    <div class="d-flex align-items-center">
        <i class="fa-solid fa-train fs-2 me-2"></i>
        <span class="text-uppercase fs-3 fw-semibold">Répartition des rames par ancienneté</span>
    </div>
    @if($percent_graph_ancien > 0)
        <div class="d-flex bg-blue-100 rounded-2 mb-10 p-5">
            {{ $percent_graph_ancien }} % de vos rames n'ont pas eu de grande visite (Check D) depuis trop longtemps. Ils s'usent donc plus rapidement.
        </div>
    @endif
    <div id="chartAncien" style="height: 300px"></div>
</div>

@push('scripts')
    @php
        $ancien_neuve = auth()->user()->railway_engines()->where('older', 0)->count();
        $ancien_basse = auth()->user()->railway_engines()->whereBetween('older', [1,2])->count();
        $ancien_forte = auth()->user()->railway_engines()->whereBetween('older', [3,4])->count();
        $ancien_extreme = auth()->user()->railway_engines()->where('older', 5)->count();

        $data = collect();
        $data->add(["value" => $ancien_neuve, "name" => "Neuf"]);
        $data->add(["value" => $ancien_basse, "name" => "Récent"]);
        $data->add(["value" => $ancien_forte, "name" => "Ancien"]);
        $data->add(["value" => $ancien_extreme, "name" => "Obsolète"]);

    @endphp
    <script src="https://fastly.jsdelivr.net/npm/echarts@5.5.0/dist/echarts.min.js"></script>
    <script>
        let chartDomAncien = document.getElementById('chartAncien')
        let chartAncien = echarts.init(chartDomAncien, null, {
            renderer: 'canvas',
            useDirtyRect: false
        });

        let optionAncien;

        optionAncien = {
            tooltip: {
                trigger: 'item',
            },
            legend: {
                top: '5%',
                left: 'center'
            },
            series: [
                {
                    name: 'Train par ancienneté',
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

        optionAncien && chartAncien.setOption(optionAncien);
    </script>
@endpush
