<div class="card shadow-sm">
    <div class="card-body">
        <div class="d-flex justify-content-between mb-5">
            <div class="d-flex">
                <div class="symbol symbol-75px border border-2 border-gray-400 me-3 p-2">
                    <img src="{{ Storage::url('icons/railway/flask.png') }}" alt="">
                </div>
                <div class="d-flex flex-column">
                    <span class="">Total Recherche: </span>
                    <div class="d-flex align-items-center mb-1">
                        <div class="symbol symbol-40px me-3">
                            <img src="{{ Storage::url('icons/railway/research.png') }}" alt="">
                        </div>
                        <span class="fs-2 fw-semibold">{{ Helpers::eur($amount_research) }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <span class="text-blue-500 fw-semibold me-5">Budget Quotidien:</span>
                        <span>{{ Helpers::eur($amount_research_budget) }}</span>
                    </div>
                </div>
            </div>
            <div class="d-flex flex-column w-50">
                <label class="fs-6 fw-semibold mb-2">
                    Budget Journalier

                    <span class="m2-1" data-bs-toggle="tooltip" title="Choisissez le budget journalier à allouer à la R&D">
                        <i class="ki-duotone ki-information fs-7"><span class="path1"></span><span class="path2"></span><span class="path3"></span></i>
                    </span>
                </label>
                <div class="d-flex flex-column text-center">
                    <div class="d-flex align-items-start justify-content-center mb-7">
                        <span class="fw-bold fs-4 mt-1 me-2">€</span>
                        <span class="fw-bold fs-3x" id="kt_modal_create_campaign_budget_label">{{ intval($amount_research_budget) }}</span>
                        <span class="fw-bold fs-3x">.00</span>
                    </div>
                    <div wire:ignore id="kt_modal_create_campaign_budget_slider" class="noUi-sm"></div>
                </div>
            </div>
        </div>
        <div class="d-flex justify-content-between align-items-center">
            <div class="bg-gray-200 rounded-3 p-5 w-40">
                @livewire('game.research.research-delivery-panel')
            </div>
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="text-center fs-4 fw-bold">Taux de change</div>
                    <div class="separator separator-dashed my-3"></div>
                    <div class="d-flex justify-content-around align-items-center">
                        <div class="d-flex align-items-center me-5">
                            <div class="symbol symbol-20px symbol-circle me-2">
                                <img src="{{ Storage::url('icons/railway/argent.png') }}" alt="">
                            </div>
                            <span>1 €</span>
                        </div>
                        <div class="d-flex align-items-center me-5">
                            <span class="fw-bolder fs-3">=</span>
                        </div>
                        <div class="d-flex align-items-center me-5">
                            <div class="symbol symbol-20px symbol-circle me-2">
                                <img src="{{ Storage::url('icons/railway/research.png') }}" alt="">
                            </div>
                            <span>{{ Helpers::eur(\App\Models\Railway\Config\RailwaySetting::where('name', 'exchange_tpoint')->first()->value) }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        var budgetSlider = document.querySelector("#kt_modal_create_campaign_budget_slider");
        var budgetValue = document.querySelector("#kt_modal_create_campaign_budget_label");

        noUiSlider.create(budgetSlider, {
            start: [{{ $amount_research_budget }}],
            connect: true,
            range: {
                "min": 0,
                "max": {{ auth()->user()->railway_company->research_coast_max }}
            },
            step: 1000,
        });

        budgetSlider.noUiSlider.on("update", function (values, handle) {
            budgetValue.innerHTML = Math.round(values[handle]);
            if (handle) {
                budgetValue.innerHTML = Math.round(values[handle]);
            }
        });

        budgetSlider.noUiSlider.on("set", function (values, handle) {
            budgetValue.innerHTML = Math.round(values[handle]);
            if (handle) {
                budgetValue.innerHTML = Math.round(values[handle]);
            }
            Livewire.dispatch(`budgetSliderUpdated`, values)
        });
    </script>
@endpush
