<div class="row">
    <x-base.alert
        type="info"
        icon="fa-solid fa-exclamation-circle"
        title="Information sur la vente de votre hub"
        content="
            La vente du hub est conditionner suivant plusieurs paramètre de votre entreprise ainsi que des actifs du hub que vous souhaitez vendre.<br>
            Cette Page vous permet de simuler la vente suivant les critères que vous selectionner.<br>
            <strong>La vente d'un hub se fait sur la base de son utilisation sur les 7 derniers jours. Vos lignes seront également vendue</strong>
            " />
    <div class="col-sm-12 col-lg-7 mb-5">
        <form action="" wire:submit.prevent="simulate" method="POST">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Vente du hub: <strong>{{ $hub->railwayHub->gare->name }}</strong></h3>
                    <div class="card-toolbar">
                        <button type="button" class="btn btn-sm btn-light" wire:loading.attr="disabled">
                            <span wire:loading.remove>Simuler</span>
                            <span wire:loading><i class="fa-solid fa-spinner fa-spin me-2"></i> Simulation en cours...</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-10">
                        <div class="form-check" wire:ignore.self>
                            <input class="form-check-input" type="checkbox" wire:model.live="sellingEngine" value="1" id="flexCheckChecked" />
                            <label class="form-check-label" for="flexCheckChecked">
                                Vendre également le matériel roulant
                            </label>
                        </div>
                    </div>
                    <div class="separator my-5"></div>
                    <x-base.title
                        title="Informations sur le hub" />
                    <div class="d-flex gap-3 mx-auto">
                        <div class="d-flex flex-column justify-content-start w-45">
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3">
                                <span class="fw-bold">Nombre de commerce</span>
                                <span class="fs-1">{{ $hub->commerce_actual }} / {{ $hub->commerce_limit }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3">
                                <span class="fw-bold">Nombre de spot publicitaire</span>
                                <span class="fs-1">{{ $hub->publicity_actual }} / {{ $hub->publicity_limit }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3">
                                <span class="fw-bold">Nombre de place de parking</span>
                                <span class="fs-1">{{ $hub->parking_actual }} / {{ $hub->parking_limit }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3">
                                <span class="fw-bold">Chiffre d'affaire (7 jours)</span>
                                <span class="fs-1">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getCA(now()->subDays(7), now())) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3">
                                <span class="fw-bold">Bénéfice (7 jours)</span>
                                <span class="fs-1">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getBenefice(now()->subDays(7), now())) }}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column justify-content-start w-45">
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 {{ $sellingEngine ? 'bg-red-200' : 'bg-gray-200' }} rounded-3">
                                <span class="fw-bold"><i class="fa-solid fa-train fs-1 me-2"></i> Matériel roulant</span>
                                <span class="fs-1">{{ $hub->userRailwayEngine->count() }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3">
                                <span class="fw-bold"><i class="fa-solid fa-route fs-1 me-2"></i> Lignes</span>
                                <span class="fs-1">{{ $hub->userRailwayLigne->count() }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3">
                                <span class="fw-bold"><i class="fa-solid fa-exclamation-triangle fs-1 me-2"></i> Incidents</span>
                                <span class="fs-1">{{ $hub->incidents->count() }}</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
    <div class="col-sm-12 col-lg-5 mb-5">
        <form action="" wire:submit="sell" method="POST">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Title</h3>
                    <div class="card-toolbar">
                        <button type="submit" class="btn btn-sm btn-success" wire:loading.attr="disabled">
                            <span wire:loading.remove>Vendre</span>
                            <span wire:loading><i class="fa-solid fa-spinner fa-spin me-2"></i> Vente en cours...</span>
                        </button>
                    </div>
                </div>
                <div class="card-body">
                    <div class="d-flex flex-column bg-gray-200 rounded-3 mb-3 p-5">
                        <div class="d-flex flex-row justify-content-between mb-2">
                            <span>Prix d'achat</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->railwayHub->price_base) }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between mb-2">
                            <span>Bénéfice</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getBenefice(now()->subDays(7), now())) }}</span>
                        </div>
                        <div class="d-flex flex-column mb-2">
                            <span class="fw-bold text-decoration-underline">Liste des lignes à vendre</span>
                            @php
                                $sellingLigne = 0;
                                foreach($hub->userRailwayLigne as $ligne) {
                                    $sellingLigne += $ligne->simulateSelling();
                                }
                            @endphp
                            @foreach($hub->userRailwayLigne as $ligne)
                                <div class="d-flex flex-row justify-content-between">
                                    <span>{{ $ligne->railwayLigne->start->name }} / {{ $ligne->railwayLigne->end->name }}</span>
                                    <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->simulateSelling()) }}</span>
                                </div>
                            @endforeach
                        </div>
                        @if($sellingEngine)
                            <div class="d-flex flex-column mb-2">
                                <span class="fw-bold text-decoration-underline">Liste des rames à vendre</span>
                                @php
                                    $sellingRame = 0;
                                    foreach($hub->userRailwayEngine as $rame) {
                                        $sellingRame += $rame->simulateSelling();
                                    }
                                @endphp
                                @foreach($hub->userRailwayEngine as $rame)
                                    <div class="d-flex flex-row justify-content-between">
                                        <span>{{ $rame->railwayEngine->name }}</span>
                                        <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($rame->simulateSelling()) }}</span>
                                    </div>
                                @endforeach
                            </div>
                        @endif
                        <div class="separator border-2 border-gray-600 my-5"></div>
                        <div class="d-flex flex-row justify-content-between mb-2">
                            <span>Total de la ventes des lignes</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($totalLigne) }}</span>
                        </div>
                        @if($sellingEngine)
                            <div class="d-flex flex-row justify-content-between mb-2">
                                <span>Total de la ventes des rames</span>
                                <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($totalEngine) }}</span>
                            </div>
                        @endif
                        <div class="d-flex flex-row justify-content-between mb-2">
                            <span>Fluctuation du marché ({{ $hub->flux_market }} %)</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($totalFlux) }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between mb-2">
                            <span>Prix actuel de revente</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($totalSelling) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </form>
    </div>
</div>
