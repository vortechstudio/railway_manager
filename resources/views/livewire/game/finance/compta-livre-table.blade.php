<div>
    <div class="d-flex mb-5" x-data="{tab: 'histo_daily'}">
        <div class="d-flex align-items-center gap-3">
            <span>Historique</span>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tab" wire:click="$set('tab', 'histo_daily')" {{ $tab == 'histo_daily' ? 'checked' : '' }} value="histo_daily"
                       id="tab"/>
                <label class="form-check-label" for="">
                    Jours
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tab" wire:click="$set('tab', 'histo_weekly')"
                       {{ $tab == 'histo_weekly' ? 'checked' : '' }} value="histo_weekly" id="tab"/>
                <label class="form-check-label" for="">
                    Semaine
                </label>
            </div>
            <div class="form-check">
                <input class="form-check-input" type="radio" name="tab" wire:click="$set('tab', 'histo_monthly')"
                       {{ $tab == 'histo_monthly' ? 'checked' : '' }} value="histo_monthly" id="tab"/>
                <label class="form-check-label" for="">
                    Mois
                </label>
            </div>
        </div>
    </div>
    @if($tab == 'histo_daily')
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive mb-5">
                    <table class="table table-bordered gap-5 gs-5 gy-5">
                        <thead>
                        <tr>
                            <th></th>
                            @for($i=6; $i >= 0; $i--)
                                <th>
                                    @if($i == 0)
                                        <div class="d-flex flex-column flex-center align-items-center text-primary">
                                            <span>Aujourd'hui</span>
                                            <span>{{ now()->subDays($i)->locale('fr_FR')->dayName }}</span>
                                        </div>
                                    @else
                                        <div class="d-flex flex-column flex-center align-items-center text-primary">
                                            <span>J-{{ $i }}</span>
                                            <span>{{ now()->subDays($i)->locale('fr_FR')->dayName }}</span>
                                        </div>
                                    @endif
                                </th>
                            @endfor
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="fs-8 text-end">
                            <td>Résultat des trajets</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountTravel = 0;
                                    foreach (auth()->user()->userRailwayLigne as $ligne) {
                                        $billetterie = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'billetterie'
                                        );
                                        $rent_aux = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'rent_trajet_aux'
                                        );
                                        $amountTravel += ($billetterie + $rent_aux);
                                    }
                                @endphp

                                <td>{{ $amountTravel > 0 ? Helpers::eur($amountTravel) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Revenue des Hubs</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountRentHub = 0;
                                    foreach (auth()->user()->userRailwayHub as $hub) {
                                        $commerce = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'commerce'
                                        );

                                        $publicity = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'publicite'
                                        );

                                        $parking = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'parking'
                                        );

                                        $amountRentHub += $commerce + $publicity + $parking;
                                    }
                                @endphp

                                <td>{{ $amountRentHub > 0 ? Helpers::eur($amountRentHub) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Versement des prets</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountInitPret = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subDays($i)->startOfDay(),
                                        to: now()->subDays($i)->endOfDay(),
                                        type_amount: 'revenue',
                                        type_mvm: 'pret'
                                    );
                                @endphp

                                <td>{{ $amountInitPret > 0 ? Helpers::eur($amountInitPret) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Divers</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountRentDivers = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subDays($i)->startOfDay(),
                                        to: now()->subDays($i)->endOfDay(),
                                        type_amount: 'revenue',
                                        type_mvm: 'divers'
                                    );
                                @endphp

                                <td>{{ $amountRentDivers > 0 ? Helpers::eur($amountRentDivers) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-6 fw-bold text-end">
                            <td>Total des Produits</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $produit = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subDays($i)->startOfDay(),
                                        to: now()->subDays($i)->endOfDay(),
                                        type_amount: 'revenue',
                                    );
                                @endphp

                                <td>{{ $produit > 0 ? Helpers::eur($produit) : '' }}</td>
                            @endfor
                        </tr>
                        </tbody>
                        <tbody>
                        <tr class="fs-8 text-end">
                            <td>Achat de Hub</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $achatHub = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'achat_hub'
                                        );
                                @endphp

                                <td class="text-red-800">{{ $achatHub != 0 ? Helpers::eur($achatHub) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Achat de Ligne</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $achatLigne = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'achat_ligne'
                                        );
                                @endphp

                                <td class="text-red-800">{{ $achatLigne != 0 ? Helpers::eur($achatLigne) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Achat de Rame</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $achatRame = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'achat_materiel'
                                        );
                                @endphp

                                <td class="text-red-800">{{ $achatRame != 0 ? Helpers::eur($achatRame) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Coûts & Charges des trajets</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $cout_trajet = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'taxe'
                                        );

                                    $fee_electricity = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'electricite'
                                        );

                                    $fee_gasoil = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'gasoil'
                                        );

                                    $chargeTravel = $cout_trajet + $fee_electricity + $fee_gasoil;
                                @endphp

                                <td class="text-red-800">{{ $chargeTravel != 0 ? Helpers::eur($chargeTravel) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Transfert R&D</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountResearch = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_mvm: 'research'
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountResearch != 0 ? Helpers::eur($amountResearch) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Remboursement de prêt</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountRembPret = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_amount: 'charge',
                                            type_mvm: 'pret',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountRembPret != 0 ? Helpers::eur($amountRembPret) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Impôt sur le revenue</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountImpot = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_amount: 'charge',
                                            type_mvm: 'impot',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountImpot != 0 ? Helpers::eur($amountImpot) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Incidents</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountIncident = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_amount: 'charge',
                                            type_mvm: 'incident',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountIncident != 0 ? Helpers::eur($amountIncident) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Maintenance des Rames</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountMaintEngine = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_amount: 'charge',
                                            type_mvm: 'maintenance_engine',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountMaintEngine != 0 ? Helpers::eur($amountMaintEngine) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Maintenance des Infrastructures</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountMaintInfra = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_amount: 'charge',
                                            type_mvm: 'maintenance_technicentre',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountMaintInfra != 0 ? Helpers::eur($amountMaintInfra) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Divers</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountChargeDivers = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subDays($i)->startOfDay(),
                                            to: now()->subDays($i)->endOfDay(),
                                            type_amount: 'charge',
                                            type_mvm: 'divers',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountChargeDivers != 0 ? Helpers::eur($amountChargeDivers) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-6 fw-bold text-end">
                            <td>Total des Charges</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $charge = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subDays($i)->startOfDay(),
                                        to: now()->subDays($i)->endOfDay(),
                                        type_amount: 'charge',
                                    );
                                @endphp

                                <td class="text-red-800">{{ $charge != 0 ? Helpers::eur($charge) : '' }}</td>
                            @endfor
                        </tr>
                        </tbody>
                    </table>
                </div>
                @php
                    $amountProduit = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subDays(7)->startOfDay(),
                                        to: now()->endOfDay(),
                                        type_amount: 'revenue',
                                    );
                    $amountCharge = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subDays(7)->startOfDay(),
                                        to: now()->endOfDay(),
                                        type_amount: 'charge',
                                    );
                @endphp
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span>Total Produit:</span>
                            <span class="fw-bolder text-success">{{ Helpers::eur($amountProduit) }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span>Total Charge:</span>
                            <span class="fw-bolder text-danger">{{ Helpers::eur($amountCharge) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
    @if($tab == 'histo_weekly')
        <div class="card shadow-sm">
            <div class="card-body">
                <div class="table-responsive mb-5">
                    <table class="table table-bordered gap-5 gs-5 gy-5">
                        <thead>
                        <tr>
                            <th></th>
                            @for($i=6; $i >= 0; $i--)
                                <th>
                                    @if($i == 0)
                                        <div class="d-flex flex-column flex-center align-items-center text-primary">
                                            <span>Semaine</span>
                                        </div>
                                    @else
                                        <div class="d-flex flex-column flex-center align-items-center text-primary">
                                            <span>S-{{ $i }}</span>
                                        </div>
                                    @endif
                                </th>
                            @endfor
                        </tr>
                        </thead>
                        <tbody>
                        <tr class="fs-8 text-end">
                            <td>Résultat des trajets</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountTravel = 0;
                                    foreach (auth()->user()->userRailwayLigne as $ligne) {
                                        $billetterie = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'billetterie'
                                        );
                                        $rent_aux = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'rent_trajet_aux'
                                        );
                                        $amountTravel += ($billetterie + $rent_aux);
                                    }
                                @endphp

                                <td>{{ $amountTravel > 0 ? Helpers::eur($amountTravel) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Revenue des Hubs</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountRentHub = 0;
                                    foreach (auth()->user()->userRailwayHub as $hub) {
                                        $commerce = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'commerce'
                                        );

                                        $publicity = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'publicite'
                                        );

                                        $parking = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'parking'
                                        );

                                        $amountRentHub += $commerce + $publicity + $parking;
                                    }
                                @endphp

                                <td>{{ $amountRentHub > 0 ? Helpers::eur($amountRentHub) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Versement des prets</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountInitPret = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subWeeks($i)->startOfWeek(),
                                        to: now()->subWeeks($i)->endOfWeek(),
                                        type_amount: 'revenue',
                                        type_mvm: 'pret'
                                    );
                                @endphp

                                <td>{{ $amountInitPret > 0 ? Helpers::eur($amountInitPret) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Divers</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountRentDivers = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subWeeks($i)->startOfWeek(),
                                        to: now()->subWeeks($i)->endOfWeek(),
                                        type_amount: 'revenue',
                                        type_mvm: 'divers'
                                    );
                                @endphp

                                <td>{{ $amountRentDivers > 0 ? Helpers::eur($amountRentDivers) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-6 fw-bold text-end">
                            <td>Total des Produits</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $produit = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subWeeks($i)->startOfWeek(),
                                        to: now()->subWeeks($i)->endOfWeek(),
                                        type_amount: 'revenue',
                                    );
                                @endphp

                                <td>{{ $produit > 0 ? Helpers::eur($produit) : '' }}</td>
                            @endfor
                        </tr>
                        </tbody>
                        <tbody>
                        <tr class="fs-8 text-end">
                            <td>Achat de Hub</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $achatHub = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'achat_hub'
                                        );
                                @endphp

                                <td class="text-red-800">{{ $achatHub != 0 ? Helpers::eur($achatHub) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Achat de Ligne</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $achatLigne = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'achat_ligne'
                                        );
                                @endphp

                                <td class="text-red-800">{{ $achatLigne != 0 ? Helpers::eur($achatLigne) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Achat de Rame</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $achatRame = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'achat_materiel'
                                        );
                                @endphp

                                <td class="text-red-800">{{ $achatRame != 0 ? Helpers::eur($achatRame) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Coûts & Charges des trajets</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $cout_trajet = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'taxe'
                                        );

                                    $fee_electricity = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'electricite'
                                        );

                                    $fee_gasoil = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'gasoil'
                                        );

                                    $chargeTravel = $cout_trajet + $fee_electricity + $fee_gasoil;
                                @endphp

                                <td class="text-red-800">{{ $chargeTravel != 0 ? Helpers::eur($chargeTravel) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Transfert R&D</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountResearch = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_mvm: 'research'
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountResearch != 0 ? Helpers::eur($amountResearch) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Remboursement de prêt</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountRembPret = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_amount: 'charge',
                                            type_mvm: 'pret',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountRembPret != 0 ? Helpers::eur($amountRembPret) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Impôt sur le revenue</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountImpot = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_amount: 'charge',
                                            type_mvm: 'impot',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountImpot != 0 ? Helpers::eur($amountImpot) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Incidents</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountIncident = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_amount: 'charge',
                                            type_mvm: 'incident',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountIncident != 0 ? Helpers::eur($amountIncident) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Maintenance des Rames</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountMaintEngine = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_amount: 'charge',
                                            type_mvm: 'maintenance_engine',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountMaintEngine != 0 ? Helpers::eur($amountMaintEngine) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Maintenance des Infrastructures</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountMaintInfra = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_amount: 'charge',
                                            type_mvm: 'maintenance_technicentre',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountMaintInfra != 0 ? Helpers::eur($amountMaintInfra) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-8 text-end">
                            <td>Divers</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $amountChargeDivers = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                            from: now()->subWeeks($i)->startOfWeek(),
                                            to: now()->subWeeks($i)->endOfWeek(),
                                            type_amount: 'charge',
                                            type_mvm: 'divers',
                                        );
                                @endphp

                                <td class="text-red-800">{{ $amountChargeDivers != 0 ? Helpers::eur($amountChargeDivers) : '' }}</td>
                            @endfor
                        </tr>
                        <tr class="fs-6 fw-bold text-end">
                            <td>Total des Charges</td>
                            @for($i=6; $i >= 0; $i--)
                                @php
                                    $charge = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subWeeks($i)->startOfWeek(),
                                        to: now()->subWeeks($i)->endOfWeek(),
                                        type_amount: 'charge',
                                    );
                                @endphp

                                <td class="text-red-800">{{ $charge != 0 ? Helpers::eur($charge) : '' }}</td>
                            @endfor
                        </tr>
                        </tbody>
                    </table>
                </div>
                @php
                    $amountProduit = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subWeeks(7)->startOfWeek(),
                                        to: now()->endOfWeek(),
                                        type_amount: 'revenue',
                                    );
                    $amountCharge = (new \App\Services\Models\User\Railway\UserRailwayMouvementAction())->getSumEcritures(
                                        from: now()->subWeeks(7)->startOfWeek(),
                                        to: now()->endOfWeek(),
                                        type_amount: 'charge',
                                    );
                @endphp
                <div class="row">
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span>Total Produit:</span>
                            <span class="fw-bolder text-success">{{ Helpers::eur($amountProduit) }}</span>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="d-flex justify-content-between">
                            <span>Total Charge:</span>
                            <span class="fw-bolder text-danger">{{ Helpers::eur($amountCharge) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    @endif
</div>
