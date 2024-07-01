@extends('layouts.app')

@section("title")
    Détail des emprunts
@endsection

@section("toolbar")
    @livewire('core.toolbar', [
        "breads" => ['Finance', 'Services Bancaires', $banque->name, 'Détail des emprunts'],
        "alertFeature" => true,
    ])
@endsection

@section("content")
    <div class="container-xxl">
        <div id="kt_app_content" class="app-content">
            <x-game.finance-menu title="Détail des emprunts" />
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
                                <span class="fw-bolder text-gray-300 fs-3hx">{{ $banque->name }}</span>
                                <span>{{ $banque->description }}</span>
                            </div>
                            <div class="row">
                                <div class="col-sm-12 col-lg-6">
                                    <div class="d-flex flex-column mb-5">
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>Taux d'intérêt</span>
                                            <span class="fw-bold">{{ $banque->latest_flux }} %</span>
                                        </div>
                                        <div class="d-flex justify-content-between align-items-center mb-2">
                                            <span>Emprunt Express</span>
                                            <div class="fw-bold">{{ Helpers::eur($banque->userRailwayEmprunts()->where('user_railway_id', auth()->user()->railway->id)->where('type_emprunt', 'express')->sum('amount_emprunt')) }}</div>
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
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Liste des emprunts</h3>
                </div>
                <div class="card-body">
                    <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Date</th>
                                <th>Montant</th>
                                <th>Taux</th>
                                <th>Etat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($banque->userRailwayEmprunts()->where('user_railway_id', auth()->user()->railway->id)->where('type_emprunt', 'express')->exists())
                                @foreach($banque->userRailwayEmprunts()->where('user_railway_id', auth()->user()->railway->id)->where('type_emprunt', 'express')->get() as $emprunt)
                                    <tr>
                                        <td>{{ $emprunt->number }}</td>
                                        <td>{{ $emprunt->date->format('d/m/Y') }}</td>
                                        <td>{{ Helpers::eur($emprunt->amount_emprunt) }}</td>
                                        <td>{{ $emprunt->taux_emprunt }} %</td>
                                        <td>{!! $emprunt->status_label !!}</td>
                                        <td>
                                            @if($emprunt->status->value == 'pending')
                                                <a href="{{ route('finance.bank.repay', [$banque->id, $emprunt->id]) }}" class="btn btn-sm btn-primary">Rembourser</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="6"><x-base.is-null text="Vous n'avez aucune demande d'emprunt express auprès de cette banque." /></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">EMPRUNT SUR LES MARCHÉS FINANCIERS</h3>
                </div>
                <div class="card-body">
                    <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                        <thead>
                            <tr>
                                <th>Numéro</th>
                                <th>Date</th>
                                <th>Montant</th>
                                <th>TS Estimé</th>
                                <th>TS Atteint</th>
                                <th>Etat</th>
                                <th></th>
                            </tr>
                        </thead>
                        <tbody>
                            @if($banque->userRailwayEmprunts()->where('user_railway_id', auth()->user()->railway->id)->where('type_emprunt', 'marche')->exists())
                                @foreach($banque->userRailwayEmprunts()->where('user_railway_id', auth()->user()->railway->id)->where('type_emprunt', 'marche')->get() as $emprunt)
                                    <tr>
                                        <td>{{ $emprunt->number }}</td>
                                        <td>{{ $emprunt->date->format('d/m/Y') }}</td>
                                        <td>{{ Helpers::eur($emprunt->amount_emprunt) }}</td>
                                        <td>{{ Helpers::eur(auth()->user()->railway_company->valorisation * $emprunt->croissance / 100) }}</td>
                                        <td>Emprunt non validé</td>
                                        <td>{!! $emprunt->status_label !!}</td>
                                        <td>
                                            @if($emprunt->status->value == 'pending')
                                                <a href="{{ route('finance.bank.repay', [$banque->id, $emprunt->id]) }}" class="btn btn-sm btn-primary">Rembourser</a>
                                            @endif
                                        </td>
                                    </tr>
                                @endforeach
                            @else
                                <tr>
                                    <td colspan="7"><x-base.is-null text="Vous n'avez aucune demande d'emprunt sur le marché publique auprès de cette banque." /></td>
                                </tr>
                            @endif
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
@endsection

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

