<div class="row">
    <x-base.alert
        type="info"
        icon="fa-solid fa-exclamation-circle"
        title="Information sur la vente de votre ligne"
        content="
            La vente d'une ligne est conditionner suivant plusieurs paramètre de votre entreprise ainsi que des actifs de la ligne que vous souhaitez vendre.<br>
            <strong>La vente d'une ligne se fait sur la base de son utilisation sur les 7 derniers jours</strong>
            " />
    <div class="col-sm-12 col-lg-7 mb-5">
        <form action="" wire:submit.prevent="simulate" method="POST">
            <div class="card shadow-sm">
                <div class="card-header">
                    <h3 class="card-title">Vente de la ligne: <strong>{{ $ligne->railwayLigne->start->name }} / {{ $ligne->railwayLigne->end->name }}</strong></h3>
                </div>
                <div class="card-body">
                    <x-base.title
                        title="Informations sur la ligne" />
                    <div class="d-flex gap-3 mx-auto">
                        <div class="d-flex flex-column justify-content-start w-45">
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3">
                                <span class="fw-bold">Chiffre d'affaire (7 jours)</span>
                                <span class="fs-1">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCA(now()->subDays(7), now())) }}</span>
                            </div>
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3">
                                <span class="fw-bold">Bénéfice (7 jours)</span>
                                <span class="fs-1">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getBenefice(now()->subDays(7), now())) }}</span>
                            </div>
                        </div>
                        <div class="d-flex flex-column justify-content-start w-45">
                            <div class="d-flex flex-row justify-content-between align-items-center p-5 mb-2 bg-gray-200 rounded-3">
                                @php
                                    $incidents = 0;

                                    foreach ($ligne->plannings()->where('status', 'arrival')->get() as $planning) {
                                        $incidents += $planning->incidents()->count();
                                    }
                                @endphp
                                <span class="fw-bold"><i class="fa-solid fa-exclamation-triangle fs-1 me-2"></i> Incidents</span>
                                <span class="fs-1">{{ $incidents }}</span>
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
                    <h3 class="card-title">&nbsp;</h3>
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
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->railwayLigne->price) }}</span>
                        </div>
                        <div class="d-flex flex-row justify-content-between mb-2">
                            <span>Bénéfice</span>
                            <span>{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getBenefice(now()->subDays(7), now())) }}</span>
                        </div>
                        <div class="separator border-2 border-gray-600 my-5"></div>
                        <div class="d-flex flex-row justify-content-between mb-2">
                            <span>Fluctuation du marché ({{ $ligne->flux_market }} %)</span>
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
