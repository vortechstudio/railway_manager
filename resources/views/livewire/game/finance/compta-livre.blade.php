<div class="card shadow-sm mb-5">
    <div class="card-header">
        <div class="card-title gap-5">
            <div class="symbol symbol-50px">
                <img src="{{ Storage::url('icons/railway/accounting.png') }}" alt="">
            </div>
            <div class="fs-3">Livre comptable</div>
        </div>
        <div class="card-toolbar">
            <ul class="nav nav-pills nav-pills-custom mb-3 gap-3" role="tablist">
                <li class="nav-item" role="presentation">
                    <a href="#table" class="nav-link btn btn-flush btn-color-muted btn-active-color-primary active m-1" data-bs-toggle="pill" aria-selected="true" role="tab">
                        <i class="fa-solid fa-list fs-2"></i>
                    </a>
                </li>
                <li class="nav-item" role="presentation">
                    <a href="#graph" class="nav-link btn btn-flush btn-color-muted btn-active-color-primary m-1" data-bs-toggle="pill" aria-selected="false" role="tab">
                        <i class="fa-solid fa-line-chart fs-2"></i>
                    </a>
                </li>
            </ul>
        </div>
    </div>
    <div class="card-body">
        <div class="tab-content">
            <div class="tab-pane fade show active" id="table" role="tabpanel">
                @livewire('game.finance.compta-livre-table')
            </div>
            <div class="tab-pane fade" id="graph" role="tabpanel">
                @livewire('game.finance.compta-livre-graph')
            </div>
        </div>
    </div>
</div>
