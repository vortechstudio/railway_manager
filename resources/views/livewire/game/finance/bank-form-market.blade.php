@php
    $bankNote = auth()->user()->railway->bank_note;
@endphp

<div wire:ignore.self class="modal fade" tabindex="-1" id="market">
    <form action="" wire:submit="save">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content">
                <div class="modal-header">
                    <h3 class="modal-title">&nbsp;</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="card shadow-sm mb-10">
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
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12 col-lg-6">
                                            @php
                                                $pending = auth()->user()->railway->userRailwayEmprunts()->where('type_emprunt', 'marcher')->where('railway_banque_id', $banque->id)->sum('amount_emprunt');
                                            @endphp
                                            <div class="d-flex flex-column mb-5">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span>Taux d'intérêt</span>
                                                    <span class="fw-bold">{{ $banque->latest_flux }} %</span>
                                                </div>
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <span>Emprunt en cours</span>
                                                    <div class="fw-bold">{{ Helpers::eur($pending) }}</div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    <x-base.title title="Votre Notation" />
                    <div class="d-flex flex-column border border-primary rounded-2 p-5 mb-5">
                        <span class="fw-bold">Fonctionnement:</span>
                        <ul>
                            <li>La note des agences de notation permet de modifier le taux d'intérêt des emprunts sur les marchés financiers.</li>
                            <li>La note AAA permet d'obtenir le meilleur taux d'intérêt possible.</li>
                            <li>La note C propose les taux les moins avantageux.</li>
                            <li>Votre note est unique et s'applique à toutes les banques.</li>
                            <li>Vous devez réaliser de nombreux emprunts sur les marchés financiers afin de la faire varier.</li>
                        </ul>
                    </div>
                    <div class="d-flex flex-wrap justify-content-between align-items-center">
                        <div class="d-flex w-40">
                            <div id="chartNote_{{ $banque->id }}" style="height: 250px; width: 100%"></div>
                        </div>
                        <div class="d-flex align-items-center flex-column mt-3 w-60">
                            <div class="d-flex justify-content-center fw-bold fs-6 opacity-75 w-100 mt-auto mb-2">
                                <span class="w-10">C</span>
                                <span class="w-10">CC</span>
                                <span class="w-10">CCC</span>
                                <span class="w-10">B</span>
                                <span class="w-10">BB</span>
                                <span class="w-10">BBB</span>
                                <span class="w-10">A</span>
                                <span class="w-10">AA</span>
                                <span class="w-20">AAA</span>
                            </div>

                            <div class="h-10px mx-3 w-100 {{ $bankNote <= 30 ? 'bg-danger' : ($bankNote <= 60 ? 'bg-warning' : 'bg-success') }} bg-opacity-50 rounded">
                                <div class="{{ $bankNote <= 30 ? 'bg-danger' : ($bankNote <= 60 ? 'bg-warning' : 'bg-success') }} rounded h-10px" role="progressbar" style="width: {{ $bankNote }}%;" aria-valuenow="{{ $bankNote }}" aria-valuemin="0" aria-valuemax="100"></div>
                            </div>
                        </div>
                    </div>
                    <div class="card shadow-sm mt-10">
                        <div class="card-header">
                            <h3 class="card-title">EMPRUNT SUR LES MARCHÉS FINANCIERS</h3>
                        </div>
                        <div class="card-body">
                            <div class="d-flex flex-column border border-gray-400 rounded-2 p-5 mb-5">
                                <span>Fonctionnement :</span>
                                <p>Choisissez la trésorerie structurelle que vous estimez pouvoir obtenir dans 7 jours. Au terme de ce délai, une agence de notation évaluera votre compagnie !</p>
                                <p>Critères d'évaluation :</p>
                                <ul>
                                    <li>Il ne faut pas être en dessous de son estimation sans quoi la note peut baisser.</li>
                                    <li>L'agence vous note uniquement en fonction de l'objectif que vous vous êtes fixé.</li>
                                </ul>
                            </div>
                            <div class="row">
                                <div class="col-4">
                                    <div class="mb-10">
                                        <label for="duration_emprunt" class="form-label required">Durée de l'emprunt</label>
                                        <select wire:ignore.self wire:model="duration_emprunt" name="duration_emprunt" id="duration_emprunt" class="form-select" data-control="select2" data-placeholder="---  Durée de l'emprunt ---" required>
                                            <option></option>
                                            @for($i=25; $i <= 50; $i++)
                                                <option value="{{ $i }}">{{ $i }} Semaines</option>
                                            @endfor
                                        </select>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-10">
                                        <label class="form-label required">Somme demandée</label>
                                        <input type="text" class="form-control" id="amount_request" name="amount_request" wire:model="amount_request" required />
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="mb-10">
                                        <label class="form-label required">Croissance estimé</label>
                                        <input type="text" class="form-control" id="croissance" name="croissance" wire:model="croissance" required />
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="card-footer">
                            <button type="submit" class="btn btn-success">Valider</button>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </form>
</div>

@push("scripts")
    <x-base.close-modal />
    <script src="https://cdn.amcharts.com/lib/5/index.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/xy.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/radar.js"></script>
    <script src="https://cdn.amcharts.com/lib/5/themes/Animated.js"></script>
    <script>
        am5.ready(function () {
            let root = am5.Root.new('chartNote_{{ $banque->id }}')
            root.setThemes([am5themes_Animated.new(root)])

            let chartNote_{{ $banque->id }} = root.container.children.push(am5radar.RadarChart.new(root, {
                panX: false,
                panY: false,
                startAngle: 160,
                endAngle: 380
            }));

            let axisRenderer = am5radar.AxisRendererCircular.new(root, {
                innerRadius: -40
            });
            axisRenderer.grid.template.setAll({
                stroke: root.interfaceColors.get("background"),
                visible: true,
                strokeOpacity: 0.8
            });

            let xAxis = chartNote_{{ $banque->id }}.xAxes.push(am5xy.ValueAxis.new(root, {
                maxDeviation: 0,
                min: 0,
                max: 100,
                strictMinMax: true,
                renderer: axisRenderer
            }));
            let axisDataItem = xAxis.makeDataItem({});
            let clockHand = am5radar.ClockHand.new(root, {
                pinRadius: am5.percent(20),
                radius: am5.percent(100),
                bottomWidth: 40
            })

            let bullet = axisDataItem.set("bullet", am5xy.AxisBullet.new(root, {
                sprite: clockHand
            }));
            xAxis.createAxisRange(axisDataItem);

            let label = chartNote_{{ $banque->id }}.radarContainer.children.push(am5.Label.new(root, {
                fill: am5.color(0xffffff),
                centerX: am5.percent(50),
                textAlign: "center",
                centerY: am5.percent(50),
                fontSize: "3em"
            }));
            axisDataItem.set("value", 10);
            bullet.get("sprite").on("rotation", function () {
                let value = axisDataItem.get("value");
                let text = Math.round(axisDataItem.get("value")).toString();
                let fill = am5.color(0x000000);
                xAxis.axisRanges.each(function (axisRange) {
                    if (value >= axisRange.get("value") && value <= axisRange.get("endValue")) {
                        fill = axisRange.get("axisFill").get("fill");
                    }
                })

                label.set("text", Math.round(value).toString());

                clockHand.pin.animate({ key: "fill", to: fill, duration: 500, easing: am5.ease.out(am5.ease.cubic) })
                clockHand.hand.animate({ key: "fill", to: fill, duration: 500, easing: am5.ease.out(am5.ease.cubic) })
            });

            axisDataItem.animate({
                key: "value",
                to: {{ $bankNote }},
                duration: 500,
                easing: am5.ease.out(am5.ease.cubic)
            });
            chartNote_{{ $banque->id }}.bulletsContainer.set("mask", undefined);

            let bandsData = [{
                title: "C",
                color: "#ee1f1f",
                lowScore: 0,
                highScore: 10
            }, {
                title: "CC",
                color: "#f02222",
                lowScore: 10,
                highScore: 20
            }, {
                title: "CCC",
                color: "#fc5353",
                lowScore: 20,
                highScore: 30
            }, {
                title: "B",
                color: "#f35d0c",
                lowScore: 30,
                highScore: 40
            }, {
                title: "BB",
                color: "#f1730c",
                lowScore: 40,
                highScore: 50
            }, {
                title: "BBB",
                color: "#f58e3a",
                lowScore: 50,
                highScore: 60
            }, {
                title: "A",
                color: "#0f9747",
                lowScore: 60,
                highScore: 70
            }, {
                title: "AA",
                color: "#0f9747",
                lowScore: 70,
                highScore: 80
            },{
                title: "AAA",
                color: "#0f9747",
                lowScore: 80,
                highScore: 100
            }];

            am5.array.each(bandsData, function (data) {
                var axisRange = xAxis.createAxisRange(xAxis.makeDataItem({}));

                axisRange.setAll({
                    value: data.lowScore,
                    endValue: data.highScore
                });

                axisRange.get("axisFill").setAll({
                    visible: true,
                    fill: am5.color(data.color),
                    fillOpacity: 0.8
                });

                axisRange.get("label").setAll({
                    text: data.title,
                    inside: true,
                    radius: 15,
                    fontSize: "0.9em",
                    fill: root.interfaceColors.get("background")
                });
            });

            chartNote_{{ $banque->id }}.appear(1000, 100);
        })
    </script>
@endpush
