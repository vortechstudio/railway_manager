<div>
    <div class="card shadow-sm">
        <div class="card-header">
            <div class="card-title">
                <div class="symbol symbol-30px symbol-circle me-3">
                    <img src="{{ Storage::url('icons/railway/maintenance.png') }}" alt="">
                </div>
                <span>Réparations / Maintenance</span>
            </div>
        </div>
        <div class="card-body">
            <div class="d-flex justify-content-center align-items-center gap-5">
                <a href="{{ route('train.index') }}" class="btn btn-primary">Réparation individuelle</a>
                <button class="btn btn-primary" data-bs-toggle="modal" data-bs-target="#repair">Réparation groupée</button>
            </div>
        </div>
    </div>
    @livewire('game.engine.engine-maintenance-group-form')
</div>
