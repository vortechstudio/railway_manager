<form action="" wire:submit="checkout" method="POST" x-data="{selectedHub: 0}">

    <div class="row">
        <div class="col-sm-12 col-lg-8 mb-5">
            <div class="card shadow-sm mb-5">
                <div class="card-body">
                    <div class="mb-10" wire:ignore.self>
                        <label for="hub_id" class="form-label required">Hub disponible</label>
                        <select wire:model.live="selectedHub" id="selectedHub" data-control="select2" class="form-select" required>
                            <option value="0">-- Aucune valeur --</option>
                            @foreach($hubs as $hub)
                                @if(!auth()->user()->userRailwayHub()->where('railway_hub_id', $hub->id)->exists())
                                    <option value="{{ $hub->id }}">{{ $hub->gare->name }}</option>
                                @endif
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>
            @if($selectedHub !== 0)
                @php ($hub = App\Models\Railway\Gare\RailwayHub::with('gare')->find($selectedHub))
                @if($hub)
                    <div class="card shadow-sm">
                        <div class="card-header">
                            <h3 class="card-title">{{ $hub->gare->name }}</h3>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-sm-12 col-lg-6 mb-5">
                                    <div class="d-flex flex-row justify-content-between w-50 p-5 bg-grey-200 rounded-3 mb-3">
                                        <span>Taxe de passage</span>
                                        <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->taxe_hub_price) }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between w-50 p-5 bg-grey-200 rounded-3 mb-3">
                                        <span>Première Classe</span>
                                        <span>{{ intval($hub->gare->passenger_first) }} P / heure</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between w-50 p-5 bg-grey-200 rounded-3 mb-3">
                                        <span>Seconde Classe</span>
                                        <span>{{ intval($hub->gare->passenger_second) }} P / heure</span>
                                    </div>
                                </div>
                                <div class="col-sm-12 col-lg-6 mb-5">
                                    <div class="d-flex flex-row justify-content-between p-5 bg-grey-200 rounded-3 mb-3">
                                        <span>Nombre Max de commerce</span>
                                        <span>{{ $hub->gare->nb_max_commerce }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between p-5 bg-grey-200 rounded-3 mb-3">
                                        <span>Nombre Max de slot publicitaire</span>
                                        <span>{{ $hub->gare->nb_max_publicite }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between p-5 bg-grey-200 rounded-3 mb-3">
                                        <span>Nombre Max de place de parking</span>
                                        <span>{{ $hub->gare->nb_max_parking }}</span>
                                    </div>
                                    <div class="d-flex flex-row justify-content-between p-5 bg-grey-200 rounded-3 mb-3">
                                        <span>Nombre de ligne disponible</span>
                                        <span>{{ $hub->lignes()->where('active', true)->count() }}</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                @endif
            @endif
        </div>
        <div class="order-sm-first order-lg-last col-sm-12 col-lg-4 mb-5">
            @if($selectedHub !== 0)
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">&nbsp;</h3>
                        <div class="card-toolbar">
                            <button type="submit" class="btn btn-sm btn-success" wire:loading.attr="disabled">
                                <span wire:loading.remove>Acheter ce hub</span>
                                <span wire:loading><i class="fa-solid fa-spinner fa-spin me-2"></i> Achat en cours...</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Hub: {{ $hub->gare->name }}</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($price_base) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subvention (- {{ $subvention_percent }} %)</span>
                            <span>- {{ \Vortechstudio\Helpers\Facades\Helpers::eur($subvention_amount) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Fluctuation du marché ({{ $flux_hub_percent }} %)</span>
                            <span> {{ \Vortechstudio\Helpers\Facades\Helpers::eur($flux_hub_amount) }}</span>
                        </div>
                        <div class="separator"></div>
                        <div class="d-flex justify-content-between mb-2 fw-bold fs-4">
                            <span>Total à payer</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($amount_paid) }}</span>
                        </div>
                    </div>
                </div>
            @else
                <x-base.alert
                    type="info"
                    title="Veuillez selectionner un hub"
                    icon="fa-solid fa-info"
                    content="" />
            @endif

        </div>
    </div>
    <x-scripts.pluginForm />
</form>
