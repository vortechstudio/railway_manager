<div>
    <div class="card shadow-sm animate__animated animate__fadeInRight animate__delay-1s h-100">
        <div class="card-header card-header-stretch bg-brown-400">
            <ul class="nav nav-tabs nav-line-tabs nav-stretch fs-4 fw-bold border-0">
                <li class="nav-item">
                    <a class="nav-link text-white border-bottom-1 border-white active" data-bs-toggle="tab" href="#registry">Mon Registre</a>
                </li>
            </ul>
        </div>
        <div class="card-body">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="registry" role="tabpanel">
                    <div class="d-flex flex-wrap justify-content-around align-items-center gap-5 animate__animated animate__fadeInUpBig animate__delay-2s mb-5">
                        <div class="d-flex flex-column justify-content-center align-items-center border border-primary rounded-2 p-5">
                            <div class="symbol symbol-70px symbol-circle border border-3">
                                <img src="{{ Storage::url('icons/railway/train.png') }}" class="w-70px" alt />
                            </div>
                            <span class="fw-bold text-gray-700 fs-1">0</span>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center border border-primary rounded-2 p-5">
                            <div class="symbol symbol-70px symbol-circle border border-3">
                                <img src="{{ Storage::url('icons/railway/hub.png') }}" class="w-70px" alt />
                            </div>
                            <span class="fw-bold text-gray-700 fs-1">0</span>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center border border-primary rounded-2 p-5">
                            <div class="symbol symbol-70px symbol-circle border border-3">
                                <img src="{{ Storage::url('icons/railway/ligne.png') }}" class="w-70px" alt />
                            </div>
                            <span class="fw-bold text-gray-700 fs-1">0</span>
                        </div>
                        <div class="d-flex flex-column justify-content-center align-items-center border border-primary rounded-2 p-5">
                            <div class="symbol symbol-70px symbol-circle border border-3">
                                <img src="{{ Storage::url('icons/railway/train_incident.png') }}" class="w-70px" alt />
                            </div>
                            <span class="fw-bold text-gray-700 fs-1">0</span>
                        </div>
                    </div>
                    <div class="d-flex flex-column animate__animated animate__fadeInUpBig animate__delay-1s mb-5">
                        <div class="d-flex justify-content-between align-items-center bg-gray-600 rounded-top-2 shadow text-white p-2">
                            <span class="fw-bold">Entreprise</span>
                            <span class="typed" data-typed="{{ $user->railway->name_company }}"></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center bg-gray-400 text-white p-2">
                            <span class="fw-bold">Secrétaire</span>
                            <span class="typed" data-typed="{{ $user->railway->name_secretary }}"></span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center bg-gray-600 rounded-bottom-2 shadow text-white p-2">
                            <span class="fw-bold">Réputation</span>
                            <span data-kt-countup="true" data-kt-countup-value="458000">0</span>
                        </div>
                    </div>
                    <div class="d-flex flex-column animate__animated animate__fadeInUpBig animate__delay-1s mb-5">
                        <div class="d-flex rounded-3 bg-grey-300 p-5 text-gray-500 fw-semibold">{{ $user->railway->desc_company }}</div>
                    </div>
                    <div class="d-flex flex-column animate__animated animate__fadeInUpBig animate__delay-3s">
                        <div class="d-flex justify-content-between align-items-center bg-gray-600 rounded-top-2 shadow text-white p-2">
                            <span>Trésorerie Structurelle</span>
                            <span data-kt-countup="true" data-kt-countup-value="4500" data-kt-countup-suffix="€">0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center bg-gray-400 text-white p-2">
                            <span>Résultat d'exploitation</span>
                            <span data-kt-countup="true" data-kt-countup-value="94500" data-kt-countup-suffix="€">0</span>
                        </div>
                        <div class="d-flex justify-content-between align-items-center bg-gray-600 rounded-bottom-2 shadow text-white p-2">
                            <span>Nombre de Quêtes effectuer</span>
                            <span data-kt-countup="true" data-kt-countup-value="30" data-kt-countup-suffix="/35">0</span>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push("scripts")
    <script src="{{ asset('/plugins/custom/typedjs/typedjs.bundle.js') }}"></script>
    <script type="text/javascript">
        document.querySelectorAll('.typed').forEach(typed => {
            //console.log(typed.dataset);
            //debugger;
            new Typed(`.${typed.className}`, {
                strings: [`${typed.dataset.typed}`],
            })
        })
    </script>

@endpush
