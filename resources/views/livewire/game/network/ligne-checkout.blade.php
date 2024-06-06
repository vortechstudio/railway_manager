<form action="" wire:submit="checkout" x-data="{selectedHub: 0}">
    <div class="row">
        <div class="col-sm-12 col-lg-8 mb-5">
            <div class="mb-10">
                <label for="selectedHubValue" class="form-label required">Hub</label>
                <select wire:model.live="selectedHubValue" data-control="select2" name="selectedHubValue" id="selectedHubValue" class="form-select"  required>
                    <option>-- Veuillez choisir un de vos hubs --</option>
                    @foreach($this->hubs as $hub)
                        <option value="{{ $hub->railway_hub_id }}">{{ $hub->railwayHub->gare->name }}</option>
                    @endforeach
                </select>
            </div>
            @if($selectedHubValue)
            <div class="mb-10">
                <label for="railway_ligne_id" class="form-label required">Ligne</label>
                <select wire:model.live="railway_ligne_id" data-control="select2" name="railway_ligne_id" id="railway_ligne_id" class="form-select"  required>
                    <option>-- Selectionner une ligne --</option>
                    @foreach($this->lignes as $ligne)
                        @if(!auth()->user()->userRailwayLigne()->where('railway_ligne_id', $ligne->id)->exists())
                            <option value="{{ $ligne->id }}">{{ $ligne->name }}</option>
                        @endif
                    @endforeach
                </select>
            </div>
            @endif
        </div>
        <div class="order-sm-first order-lg-last col-sm-12 col-lg-4 mb-5">

            @if($railway_ligne_id !== null)
                <div class="card shadow-sm">
                    <div class="card-header">
                        <h3 class="card-title">&nbsp;</h3>
                        <div class="card-toolbar">
                            <button type="submit" class="btn btn-sm btn-success" wire:loading.attr="disabled" wire:target="checkout">
                                <span wire:loading.remove wire:target="checkout">Acheter cette ligne</span>
                                <span wire:loading wire:target="checkout"><i class="fa-solid fa-spinner fa-spin me-2"></i> Achat en cours...</span>
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="d-flex justify-content-between mb-2">
                            <span>Ligne: {{ $ligne->name }}</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($price_base) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Subvention (- {{ $subvention_percent }} %)</span>
                            <span>- {{ \Vortechstudio\Helpers\Facades\Helpers::eur($subvention_amount) }}</span>
                        </div>
                        <div class="d-flex justify-content-between mb-2">
                            <span>Fluctuation du marché ({{ $flux_ligne_percent }} %)</span>
                            <span> {{ \Vortechstudio\Helpers\Facades\Helpers::eur($flux_ligne_amount) }}</span>
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
                    title="Veuillez selectionner une ligne"
                    icon="fa-solid fa-info"
                    content="" />
            @endif
        </div>
    </div>
</form>

<x-scripts.pluginForm />
