<div x-data="{card_type: true, card_choice: false, card_config: false, card_checkout: false}">
    <form action="" wire:submit="checkout">
        <div class="card shadow-sm" x-show="card_type">
            <div class="card-header">
                <h3 class="card-title">Choix du type de matériel</h3>
            </div>
            <div class="card-body">
                <div class="d-flex flex-row justify-content-center align-items-center p-5 gap-5">
                    <div>
                        <input type="radio" class="btn-check" wire:model.live="selectedType" name="selectedType" value="ter" id="select_ter"/>
                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5 w-150px h-100px" for="select_ter">
                            <img src="{{ Storage::url('icons/railway/transport/logo_ter.svg') }}" class="w-100px" alt="">
                        </label>
                    </div>
                    <div>
                        <input type="radio" class="btn-check" wire:model.live="selectedType" name="selectedType" value="tgv" id="select_tgv"/>
                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5 w-150px h-100px" for="select_tgv">
                            <img src="{{ Storage::url('icons/railway/transport/logo_tgv.svg') }}" class="w-100px" alt="">
                        </label>
                    </div>
                    <div>
                        <input type="radio" class="btn-check" wire:model.live="selectedType" name="selectedType" value="intercity" id="select_intercity"/>
                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex align-items-center mb-5 w-150px h-100px" for="select_intercity">
                            <img src="{{ Storage::url('icons/railway/transport/logo_intercity.svg') }}" class="w-100px" alt="">
                        </label>
                    </div>
                    <div>
                        <input type="radio" class="btn-check" wire:model.live="selectedType" name="selectedType" value="tram" id="select_tram"/>
                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex justify-content-center align-items-center mb-5 w-150px h-100px" for="select_tram">
                            <img src="{{ Storage::url('icons/railway/transport/logo_tram.svg') }}" class="w-50px" alt="">
                        </label>
                    </div>
                    <div>
                        <input type="radio" class="btn-check" wire:model.live="selectedType" name="selectedType" value="metro" id="select_metro"/>
                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex justify-content-center align-items-center mb-5 w-150px h-100px" for="select_metro">
                            <img src="{{ Storage::url('icons/railway/transport/logo_metro.svg') }}" class="w-50px" alt="">
                        </label>
                    </div>
                    <div>
                        <input type="radio" class="btn-check" wire:model.live="selectedType" name="selectedType" value="other" id="select_other"/>
                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex justify-content-center align-items-center mb-5 w-150px h-100px" for="select_other">
                            <span class="fw-bold fs-1">Autre Matériel</span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-end align-items-center">
                    @if($selectedType)
                    <button type="button" x-on:click="card_type = false; card_choice = true;" class="btn btn-lg btn-outline btn-outline-secondary">
                        <i class="fa-solid fa-arrow-alt-circle-right me-3"></i>
                        <span>Suivant</span>
                    </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="card shadow-sm" x-show="card_choice">
            <div class="card-header">
                <h3 class="card-title">Choix du matériel</h3>
            </div>
            <div class="card-body">
                <div class="d-flex align-items-center gap-3 p-5 mb-5 bg-gray-300 rounded-3 mb-10">
                    <div>
                        <label for="type_energy" class="form-label">Type d'énergie</label>
                        <select wire:model.live="type_energy" name="type_energy" id="type_energy" class="form-select">
                            <option></option>
                            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Engine\RailwayEngineEnergyEnum::class)->toArray() as $type)
                                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <label for="type_train" class="form-label">Type de matériel</label>
                        <select wire:model.live="type_train" name="type_train" id="type_train" class="form-select">
                            <option></option>
                            @foreach(\Spatie\LaravelOptions\Options::forEnum(\App\Enums\Railway\Engine\RailwayEngineTrainEnum::class)->toArray() as $type)
                                <option value="{{ $type['value'] }}">{{ $type['label'] }}</option>
                            @endforeach
                        </select>
                    </div>
                    <div>
                        <div class="form-check form-check-custom form-check-solid mb-3">
                            <input class="form-check-input" wire:model.live="price_order" type="radio" value="asc" id="price_order_asc"/>
                            <label class="form-check-label" for="price_order_asc">
                                Prix -
                            </label>
                        </div>
                        <div class="form-check form-check-custom form-check-solid">
                            <input class="form-check-input" wire:model.live="price_order" type="radio" value="desc" id="price_order_desc"/>
                            <label class="form-check-label" for="price_order_desc">
                                Prix +
                            </label>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column gap-5">
                    @foreach($engines as $engine)
                        <input type="radio" class="btn-check" wire:model.live="selectedEngine" name="selectedEngine" value="{{ $engine->id }}" id="engine_{{ Str::snake($engine->name) }}"/>
                        <label class="btn btn-outline btn-outline-dashed btn-active-light-primary p-7 d-flex mb-5" for="engine_{{ Str::snake($engine->name) }}">
                            <div class="card shadow-lg w-100">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $engine->name }}</h3>
                                </div>
                                <div class="card-body">
                                    <div class="d-flex align-items-center">
                                        <div class="me-5">
                                            <img src="{{ $engine->getFirstImage($engine->id) }}" class="w-150px img-thumbnail" alt="">
                                        </div>
                                        <div class="row w-100">
                                            <div class="col-6">
                                                <div class="fs-5 fw-bold">Informations</div>
                                                <ul>
                                                    <li>Limite d'activité: <strong>{{ (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engine))->maxRuntime() }} Km</strong></li>
                                                    <li>Vitesse d'usure: <strong>5.6%/100h</strong></li>
                                                    <li>Sieges: <strong>{{ $engine->technical->nb_marchandise }} P</strong></li>
                                                    <li>Vitesse: <strong>{{ $engine->technical->velocity }} Km/h</strong></li>
                                                </ul>
                                            </div>
                                            <div class="col-6">
                                                <div class="fs-5 fw-bold">Prix</div>
                                                @php
                                                $totalPrice = 0;
                                                if($engine->price->in_reduction) {
                                                    $totalPrice = $engine->price->achat - ($engine->price->achat * $engine->price->percent_reduction / 100);
                                                } else {
                                                    $totalPrice = $engine->price->achat;
                                                }
                                                @endphp
                                                <ul>
                                                    <li>Prix Brut: <strong>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($engine->price->achat) }}</strong></li>
                                                    @if($engine->price->in_reduction)
                                                        <li class="fw-bold text-amber-600">Réduction: <strong>{{ $engine->price->percent_reduction }} %</strong></li>
                                                        <li>Prix Total: <strong>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($totalPrice) }}</strong></li>
                                                    @endif
                                                </ul>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </label>
                    @endforeach
                </div>
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" x-on:click="card_choice = false; card_type = true;" class="btn btn-lg btn-outline btn-outline-secondary">
                        <i class="fa-solid fa-arrow-alt-circle-left me-3"></i>
                        <span>Précédent</span>
                    </button>
                    @if($selectedEngine)
                        <button type="button" x-on:click="card_choice = false; card_config = true" class="btn btn-lg btn-outline btn-outline-secondary">
                            <i class="fa-solid fa-arrow-alt-circle-right me-3"></i>
                            <span>Suivant</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="card shadow-sm" x-show="card_config">
            <div class="card-header">
                <h3 class="card-title">Configuration du matériel</h3>
            </div>
            <div class="card-body">
                @if(isset($engineData))
                    @php
                        $subtotal = $engineData->price->achat * $qte;
                        $totalAmount = 0;
                        $amount_reduction = 0;
                        $globalAmount = 0;
                        if($engineData->price->in_reduction) {
                            $amount_reduction = $subtotal * $engineData->price->percent_reduction / 100;
                            $totalAmount = $subtotal - $amount_reduction;
                        } else {
                            $totalAmount = $subtotal;
                        }

                        $flux_percent = \App\Models\Railway\Config\RailwayFluxMarket::where('date', \Carbon\Carbon::today())->first()->flux_engine;
                        $amount_flux = $totalAmount * $flux_percent / 100;
                        $amount_subvention = $totalAmount * auth()->user()->railway_company->subvention / 100;
                        $globalAmount = $totalAmount - $amount_flux - $amount_subvention;
                    @endphp
                    <div class="card shadow-sm mb-5">
                        <div class="card-header">
                            <h3 class="card-title">{{ $engineData->name }}</h3>
                            <div class="card-toolbar gap-5 align-items-center">
                                <div>
                                    <label for="qte" class="form-label">Qte</label>
                                    <input type="number" wire:model.live="qte" class="form-control form-control-sm" />
                                </div>
                                <div>
                                    <span>Prix:</span>
                                    <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($subtotal) }}</span>
                                </div>
                                <div class="mb-10 d-flex align-items-center">
                                    <label for="user_railway_hub_id" class="form-label required">Hub de livraison</label>
                                    <select wire:model.live="user_railway_hub_id" name="user_railway_hub_id" id="user_railway_hub_id" class="form-select" required>
                                        <option></option>
                                        @foreach(auth()->user()->userRailwayHub()->where('active', true)->get() as $hub)
                                            <option value="{{ $hub->id }}">{{ $hub->railwayHub->gare->name }}</option>
                                        @endforeach
                                    </select>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="d-flex align-items-center">
                                <div class="me-5">
                                    <img src="{{ $engineData->getFirstImage($engine->id) }}" class="w-150px img-thumbnail" alt="">
                                </div>
                                <div class="row w-100">
                                    <div class="col-6">
                                        <div class="fs-5 fw-bold">Informations</div>
                                        <ul>
                                            <li>Limite d'activité: <strong>{{ (new \App\Services\Models\Railway\Engine\RailwayEngineAction($engineData))->maxRuntime() }} Km</strong></li>
                                            <li>Vitesse d'usure: <strong>5.6%/100h</strong></li>
                                            <li>Sieges: <strong>{{ $engineData->technical->nb_marchandise }} P</strong></li>
                                            <li>Vitesse: <strong>{{ $engineData->technical->velocity }} Km/h</strong></li>
                                        </ul>
                                    </div>
                                    <div class="col-6">
                                        @if($engineData->type_transport->value == 'ter' || $engineData->type_transport->value == 'other')
                                            <div class="d-flex flex-row mb-1">
                                                <span class="me-2">Classe Unique: <span class="fw-bold">{{ $engineData->technical->nb_marchandise }} P</span></span>
                                            </div>
                                        @else
                                            <div class="d-flex flex-row mb-1">
                                                <span class="me-2">1ere Classe: <span class="fw-bold">{{ intval($engineData->technical->nb_marchandise * 20 / 100) }} P</span></span>
                                            </div>
                                            <div class="d-flex flex-row mb-1">
                                                <span class="me-2">2eme Classe: <span class="fw-bold">{{ intval($engineData->technical->nb_marchandise * 80 / 100) }} P</span></span>
                                            </div>
                                        @endif
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    @if($engineData->type_train->value == 'automotrice')
                        <div class="d-flex flex-row justify-content-center align-items-end h-auto py-3 bg-gray-500 rounded-3 mb-5">
                            @for($w = 0; $w <= $engine->technical->nb_wagon; $w++)
                                <img src="{{ Storage::url("engines/automotrice/{$engineData->slug}-{$w}.gif") }}" alt="">
                            @endfor
                        </div>
                    @endif
                    <div class="d-flex flex-column align-items-center h-auto py-3 bg-gray-500 rounded-3 mb-5">
                        <div class="fw-bolder fs-1 fs-underline mb-3">Récapitulatif de votre achat</div>
                        <div class="d-flex flex-column w-450px lozad" id="cart">
                            <div id="product">
                                <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                    <span class="fs-3">{{ $engineData->name }} <small>X {{ $qte }}</small></span>
                                    <span class="fw-semibold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($subtotal) }}</span>
                                </div>
                            </div>
                            <div id="livre" class="d-none">
                                <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                    <span class="fs-3">Livré TER <small>X 1</small></span>
                                    <span class="fw-semibold">0 €</span>
                                </div>
                                <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                    <span class="fs-3">Livré TER Pays de la loire <small>X 1</small></span>
                                    <span class="fw-semibold">0 €</span>
                                </div>
                            </div>

                            <div class="separator border-gray-800 my-10"></div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span class="fs-3">Sous Total</span>
                                <span class="fw-semibold" data-content="subtotal">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($subtotal) }}</span>
                            </div>
                            @if($engineData->price->in_reduction)
                                <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                    <span class="fs-3">Réduction ({{ $engineData->price->percent_reduction }} %):</span>
                                    <span class="fw-semibold" data-content="reduc">- {{ \Vortechstudio\Helpers\Facades\Helpers::eur($amount_reduction) }}</span>
                                </div>
                            @endif
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span class="fs-3">Subvention (<span data-content="subvention_percent">{{ auth()->user()->railway_company->subvention }} %</span>):</span>
                                <span class="fw-semibold" data-content="subvention">- {{ Helpers::eur($amount_subvention) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-1">
                                <span class="fs-3">Fluctuation du marché (<span data-content="subvention_percent">{{ $flux_percent }} %</span>):</span>
                                <span class="fw-semibold" data-content="subvention">{{ Helpers::eur($amount_flux) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center mb-5">
                                <span class="fs-1 fw-bold">Total à payer</span>
                                <span class="fw-bold fs-1 text-danger" data-content="total_price">{{ Helpers::eur($globalAmount) }}</span>
                            </div>
                            <!-- TODO: Input de livrée choisie -->
                            <div>
                                <div class="form-check">
                                    <input class="form-check-input" type="checkbox" wire:model.live="validateConfig" value="true" id="flexCheckDefault" />
                                    <label class="form-check-label text-white" for="flexCheckDefault">
                                        Confirmer la validation de la configuration
                                    </label>
                                </div>
                            </div>
                        </div>
                    </div>
                @endisset
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" x-on:click="card_config = false; card_choice = true;" class="btn btn-lg btn-outline btn-outline-secondary">
                        <i class="fa-solid fa-arrow-alt-circle-left me-3"></i>
                        <span>Précédent</span>
                    </button>
                    @if($validateConfig && $user_railway_hub_id)
                        <button type="button" x-on:click="card_config = false; card_checkout = true" class="btn btn-lg btn-outline btn-outline-secondary">
                            <i class="fa-solid fa-arrow-alt-circle-right me-3"></i>
                            <span>Suivant</span>
                        </button>
                    @endif
                </div>
            </div>
        </div>
        <div class="card shadow-sm" x-show="card_checkout">
            <div class="card-header">
                <h3 class="card-title">Récapitulatif avant achat</h3>
            </div>
            <div class="card-body">
                @isset($engineData)
                    @php
                        $subtotal = $engineData->price->achat * $qte;
                        $totalAmount = 0;
                        $amount_reduction = 0;
                        $globalAmount = 0;
                        if($engineData->price->in_reduction) {
                            $amount_reduction = $subtotal * $engineData->price->percent_reduction / 100;
                            $totalAmount = $subtotal - $amount_reduction;
                        } else {
                            $totalAmount = $subtotal;
                        }

                        $flux_percent = \App\Models\Railway\Config\RailwayFluxMarket::where('date', \Carbon\Carbon::today())->first()->flux_engine;
                        $amount_flux = $totalAmount * $flux_percent / 100;
                        $amount_subvention = $totalAmount * auth()->user()->railway_company->subvention / 100;
                        $globalAmount = $totalAmount - $amount_flux - $amount_subvention;
                    @endphp
                    <div class="d-flex justify-content-between align-items-center p-5 rounded-3 bg-gray-300 animate__animated animate__fadeInRight">
                        <div class="gap-4">
                            <div class="symbol symbol-50">
                                <div class="symbol-label bg-red-300">x{{ $qte }}</div>
                            </div>
                            <span class="fw-bold fs-1">{{ $engineData->name }}</span>
                        </div>
                        <span class="fw-bold fs-1 text-red-600">- {{ Helpers::eur($globalAmount) }}</span>
                    </div>
                    <input type="hidden" wire:model="globalAmount" value="{{ $globalAmount }}">
                @endisset
            </div>
            <div class="card-footer">
                <div class="d-flex justify-content-between align-items-center">
                    <button type="button" x-on:click="card_checkout = false; card_config = true;" class="btn btn-lg btn-outline btn-outline-secondary">
                        <i class="fa-solid fa-arrow-alt-circle-left me-3"></i>
                        <span>Précédent</span>
                    </button>
                    <button type="submit" class="btn btn-lg btn-outline btn-outline-success">
                        <i class="fa-solid fa-shopping-cart me-3"></i>
                        <span>Valider l'achat</span>
                    </button>
                </div>
            </div>
        </div>
    </form>
</div>
