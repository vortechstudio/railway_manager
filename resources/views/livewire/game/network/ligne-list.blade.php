<div>
    @if(count($lignes) == 0)
        <x-base.is-null
            text="Aucune Ligne active actuellement" />
    @else
        @foreach($lignes as $ligne)
            <div class="d-flex flex-column bg-white p-5 mb-5 rounded-2">
                <div class="d-flex flex-row justify-content-between align-items-center border border-bottom-2 border-top-0 border-left-0 border-right-0 pb-1 mb-5">
                    <div class="d-flex align-items-center">
                        <span class="badge bagde-circle badge-primary text-white me-2">Ligne</span>
                        <span class="fw-bold fs-3">{{ $ligne->railwayLigne->start->name }} <-> {{ $ligne->railwayLigne->end->name }}</span>
                    </div>
                    <a href="{{ route('network.line.show', $ligne->id) }}" class="btn btn-flex bg-blue-600 bg-hover-primary">
                                <span class="symbol symbol-35px me-2">
                                    <img src="{{ Storage::url('icons/railway/ligne.png') }}" alt="">
                                </span>
                        <span class="text-white">Détail de la ligne</span>
                    </a>
                </div>
                <div class="d-flex flex-row align-items-center">
                    {!! $ligne->ratio_performance !!}
                    <div class="d-flex align-items-center me-5">
                        <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                        <span class="me-2">Distance: </span>
                        <span class="fw-bold">{{ $ligne->railwayLigne->distance }} Km</span>
                    </div>
                    <div class="d-flex align-items-center me-5">
                        <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                        <span class="me-2">Offre Actuel: </span>
                        <span class="fw-bold">{{ $ligne->getActualOffreLigne() }} P</span>
                    </div>
                    <div class="d-flex align-items-center me-5">
                        <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                        <span class="me-2">Chiffre d'affaires: </span>
                        <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getCA()) }}</span>
                    </div>
                    <div class="d-flex align-items-center me-5">
                        <span class="bullet bullet-dot bg-black w-5px h-5px me-2"></span>
                        <span class="me-2">Bénéfices: </span>
                        <span class="fw-bold">{{ \Vortechstudio\Helpers\Facades\Helpers::eur($ligne->getBenefice()) }}</span>
                    </div>

                </div>
            </div>
        @endforeach
    @endif
</div>
