<div>
    @if(count($hubs) == 0)
        <x-base.is-null
            text="Aucun hub disponible actuellement" />
    @else
        @foreach($hubs as $hub)
            <div class="d-flex flex-column bg-orange-100 p-5 mb-5 rounded-2">
                <div class="d-flex flex-row justify-content-between align-items-center border border-bottom-2 border-top-0 border-left-0 border-right-0 pb-1 mb-5">
                    <div class="d-flex align-items-center">
                        <span class="badge bagde-circle badge-warning text-white me-2">Hub</span>
                        <span class="fw-bold fs-3">{{ $hub->railwayHub->gare->name }}</span>
                    </div>
                    <a href="{{ route('network.hub.show', $hub->id) }}" class="btn btn-flex bg-orange-600">
                        <span class="symbol symbol-35px me-2">
                            <img src="{{ Storage::url('icons/railway/hub.png') }}" alt="">
                        </span>
                        <span class="text-white">Détail du Hub</span>
                    </a>
                </div>
                <div class="d-flex flex-row align-items-center">
                    {!! $hub->getRatioPerformance() !!}
                    <div class="d-flex align-items-center me-5">
                        <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                        <span class="me-2">Chiffre d'affaires: </span>
                        <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getCA()) }}</span>
                    </div>
                    <div class="d-flex align-items-center me-5">
                        <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                        <span class="me-2">Bénéfices: </span>
                        <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($hub->getBenefice()) }}</span>
                    </div>
                </div>
            </div>
        @endforeach
    @endif
</div>
