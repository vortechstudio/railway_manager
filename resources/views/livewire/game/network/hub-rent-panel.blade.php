<div>
    <div class="d-flex justify-content-center align-items-center bg-gray-100 rounded-3 p-5 mb-10">
        <ul class="nav nav-pills nav-pills-custom">
            <li class="nav-item me-3 me-lg-6" role="presentation">
                <a href="#commerces" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary text-active-primary flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px active">
                    <i class="fa-solid fa-shop text-muted fs-3x" data-bs-toggle="tooltip" data-bs-title="Commerces"></i>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                </a>
            </li>
            <li class="nav-item me-3 me-lg-6" role="presentation">
                <a href="#publicities" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary text-active-primary flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px">
                    <i class="fa-solid fa-bullhorn text-muted fs-3x" data-bs-toggle="tooltip" data-bs-title="Publicité"></i>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                </a>
            </li>
            <li class="nav-item me-3 me-lg-6" role="presentation">
                <a href="#parkings" data-bs-toggle="pill" class="nav-link btn btn-outline btn-flex btn-color-muted btn-active-color-primary text-active-primary flex-column align-items-center justify-content-center overflow-hidden w-80px h-80px">
                    <i class="fa-solid fa-parking text-muted fs-3x" data-bs-toggle="tooltip" data-bs-title="Parkings"></i>
                    <span class="bullet-custom position-absolute bottom-0 w-100 h-4px bg-primary"></span>
                </a>
            </li>
        </ul>
    </div>
    <div class="tab-content">
        <div class="tab-pane fade show active" id="commerces" role="tabpanel">
            @livewire('game.network.hub-rent-commerce-panel', ['hub' => $hub])
        </div>
        <div class="tab-pane fade" id="publicities" role="tabpanel">
            @livewire('game.network.hub-rent-publicity-panel', ['hub' => $hub])
        </div>
        <div class="tab-pane fade" id="parkings" role="tabpanel">
            @livewire('game.network.hub-rent-parking-panel', ['hub' => $hub])
        </div>
    </div>

</div>
