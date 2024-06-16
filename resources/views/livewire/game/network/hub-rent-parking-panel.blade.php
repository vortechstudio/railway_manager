<div>
    <div class="row">
        <div class="col-sm-12 col-lg-9 mb-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex justify-content-between align-items-center rounded-2 bg-gray-100 mb-2 p-5">
                        <span class="fs-4">CA Hier</span>
                        <span class="fs-3 fw-bold">0,00 €</span>
                    </div>
                    <div class="d-flex justify-content-between align-items-center rounded-2 bg-gray-100 mb-2 p-5">
                        <span class="fs-4">CA Prévu Aujourd'hui</span>
                        <span class="fs-3 fw-bold">0,00 €</span>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-sm-12 col-lg-3 mb-5">
            <div class="card shadow-sm">
                <div class="card-body">
                    <div class="d-flex align-items-center">
                        <div class="symbol symbol-70px me-3">
                            <i class="fa-solid fa-parking fs-1"></i>
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fs-6">Nombre de place de parking</span>
                            <span class="fs-2 fw-bolder">{{ $hub->parking_limit }}</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
