<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
            <div class="card-toolbar">
                <div class="d-flex flex-row align-items-center">
                    <div class="d-flex bg-gray-200 rounded-start-2 rounded-0 p-2 h-50px">
                        <div class="symbol symbol-30px">
                            <img src="{{ Storage::url('icons/railway/maintenance.png') }}" alt="">
                        </div>
                    </div>
                    <div class="d-flex align-items-center justify-content-start bg-gray-200 p-2 h-50px w-150px">
                        <span class="fs-1 fw-bold">{{ $research_mat }}</span>
                    </div>
                    <div class="d-flex align-items-center justify-content-center bg-gray-200 rounded-end-2 rounded-0 p-2 h-50px">
                        <i class="fa-solid fa-info-circle text-info fs-2" data-bs-toggle="popover" data-bs-trigger="hover" data-bs-custom-class="inverse" title="Information" data-bs-content="Les points de recherche de matériel permette l'achat d'amélioration pour vos rames, vous les obtenez à chaque fin de mission."></i>
                    </div>
                </div>
            </div>
        </div>
        <div class="card-body h-500px scroll animated-background">
            @foreach(auth()->user()->railway_engines as $engine)
                @livewire('game.research.research-engine-card', ['engine' => $engine])
            @endforeach
        </div>
    </div>
</div>
