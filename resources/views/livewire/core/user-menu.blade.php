<div class="app-navbar-item ms-1 ms-lg-5">
    <!--begin::Menu wrapper-->
    <div class="btn btn-icon btn-custom btn-color-gray-600 btn-active-light btn-active-color-primary w-35px h-35px w-md-40px h-md-40px position-relative" id="drawer_user_menu_toggle">
        <i class="ki-duotone ki-phone fs-1">
            <span class="path1"></span>
            <span class="path2"></span>
        </i>
        <span id="unreadBull">
            @if($countMessage > 0)
                <span class="badge badge-sm badge-circle badge-danger position-absolute top-0 start-100 translate-middle"><i class="fa-solid fa-exclamation text-white"></i> </span>
            @endif
        </span>
    </div>
    <!--end::Menu wrapper-->
    <div id="drawer_user_menu" class="bg-body" data-kt-drawer="true" data-kt-drawer-name="menu"
         data-kt-drawer-activate="true"
         data-kt-drawer-overlay="true"
         data-kt-drawer-permanent="true"
         data-kt-drawer-width="{default:'300px', 'md': '500px'}" data-kt-drawer-direction="end"
         data-kt-drawer-toggle="#drawer_user_menu_toggle" data-kt-drawer-close="#drawer_user_menu_close">
        <div class="d-flex flex-row-fluid backgroundGradient p-5"
             style="background-image: url('{{ Storage::url('services/'.$service->id.'/wall_login.png') }}'), linear-gradient(to top, rgba(0,0,0,0), rgba(0,0,0,0))">
            <div class="d-flex flex-column w-85 p-2 bg-gray-200 bg-opacity-50"
                 style="border-top-left-radius: 2rem; border-bottom-left-radius: 2rem">
                <div class="d-flex flex-row justify-content-between align-items-center m-2">
                    <div class="d-flex rounded-3 bg-gray-100 p-2">
                        <span class="fw-semibold me-1">Uid</span>
                        <span>{{ $user->railway->uuid }}</span>
                    </div>
                    <div class="d-flex align-items-center">
                        <i class="fa-solid fa-battery-full text-white fs-2 me-2"></i>
                        <i class="fa-solid fa-signal-perfect text-white fs-2"></i>
                    </div>
                </div>
                <div class="d-flex flex-row justify-content-between align-items-center m-2">
                    <div class="d-flex align-items-center mt-4">
                        <div class="symbol symbol-50px symbol-circle me-5">
                            <img src="{{ $user->socials()->first()->avatar }}" alt="">
                        </div>
                        <div class="d-flex flex-column">
                            <span class="fw-bold text-orange-700 fs-2">{{ $user->name }}</span>
                            <div class="fs-3">
                                <span class="fw-bold me-1">Réputation:</span>
                                <span class="me-2">{{ $user->railway->reputation }}</span>
                                <i class="fa-solid fa-info-circle fs-3 text-dark" data-bs-toggle="popover"
                                   data-bs-placement="bottom" title="Information sur la réputation"
                                   data-bs-content="La réputation augmente suivant votre niveau, si des objectifs sont remplie et si des paliers de valorisation de votre entreprise sont passer."></i>
                            </div>
                        </div>
                    </div>
                    <div>
                        <button class="btn btn-sm btn-circle btn-icon btn-outline btn-outline-dark"
                                data-kt-menu-trigger="click" data-kt-menu-placement="bottom"
                                data-kt-menu-offset="30px, 5px">
                            <i class="fa-solid fa-ellipsis-h"></i>
                        </button>
                        <div
                            class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px"
                            data-kt-menu="true">
                            <div class="menu-item px-3">
                                <a href="{{ route('account.profil') }}" class="menu-link px-3">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-user-circle me-2"></i>
                                </span>
                                    <span class="menu-title">Mon Profil</span>
                                </a>
                            </div>
                            <div class="menu-item px-3">
                                <a href="{{ route('shop.index') }}" class="menu-link px-3">
                                <span class="menu-icon">
                                    <i class="fa-solid fa-shopping-cart me-2"></i>
                                </span>
                                    <span class="menu-title">Boutique</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-wrap w-100 h-50px m-2 rounded-2 bg-gray-600 bg-opacity-50 p-2">
                    {!! $user->profil->signature ?? 'Aucune signature' !!}
                </div>
                <div class="d-flex flex-column m-2">
                    <div class="d-flex flex-row justify-content-between align-items-center">
                        <div class="text-orange-700 fw-semibold fs-4">
                            <span class="me-2">Niveau de direction</span>
                            <span>{{ $user->railway->level }}</span>
                        </div>
                        <div class="fs-4 text-gray-800 fw-semibold">
                            <span>Expérience</span>
                            <span>{{ $user->railway->xp }}/{{ $user->railway->next_level_xp }}</span>
                        </div>
                    </div>
                    <div class="h-8px mx-3 w-100 bg-white bg-opacity-50 rounded">
                        <div class="bg-orange-500 rounded h-8px" role="progressbar"
                             style="width: {{ $user->railway->xp_percent }}%;"
                             aria-valuenow="{{ $user->railway->xp_percent }}" aria-valuemin="0" aria-valuemax="100"></div>
                    </div>
                </div>
                <div class="w-100 h-75 hover-scroll-y hover-scroll-x">
                    <div class="row">
                        <div class="col-md-4">
                            <a href="{{ route('trophy.index') }}"
                               class="d-flex h-150px flex-column flex-center text-center text-gray-800 text-hover-gray-800 bg-primary bg-opacity-75 bg-hover-light-primary rounded-2 p-5 mb-3 me-3">
                    <span class="symbol symbol-75px">
                        <img src="{{ Storage::url('icons/railway/trophy.png') }}" class="w-75px" alt>
                    </span>
                                <span class="fs-semibold fs-3">Succès</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href=""
                               class="d-flex h-150px flex-column flex-center text-center text-gray-800 text-hover-gray-800 bg-primary bg-opacity-75 bg-hover-light-primary rounded-2 p-5 mb-3 me-3">
                    <span class="symbol symbol-75px">
                        <img src="{{ Storage::url('icons/railway/hub.png') }}" class="w-75px" alt>
                    </span>
                                <span class="fs-semibold fs-3">Hub</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <a href=""
                               class="d-flex h-150px flex-column flex-center text-center text-gray-800 text-hover-gray-800 bg-primary bg-opacity-75 bg-hover-light-primary rounded-2 p-5 mb-3 me-3">
                                <span class="symbol symbol-75px">
                                    <img src="{{ Storage::url('icons/railway/gatcha.png') }}" class="w-75px" alt>
                                </span>
                                <span class="fs-semibold fs-3">Concession</span>
                            </a>
                        </div>
                        <div class="col-md-4">
                            <button id="drawer_bug_tracker_button"
                               class="d-flex h-150px flex-column flex-center text-center text-gray-800 text-hover-gray-800 bg-primary bg-opacity-75 bg-hover-light-primary rounded-2 p-5 mb-3 me-3">
                                <span class="symbol symbol-75px">
                                    <img src="{{ Storage::url('icons/railway/bug.png') }}" class="w-75px" alt>
                                </span>
                                <span class="fs-semibold fs-3">Rapport de Bug</span>
                            </button>
                        </div>
                        <div class="col-md-4">
                            <button wire:click="readVersion" id="drawer_version_button"
                                    class="d-flex h-150px flex-column flex-center text-center text-gray-800 text-hover-gray-800 bg-primary bg-opacity-75 bg-hover-light-primary rounded-2 p-5 mb-3 me-3 position-relative">
                                <span class="symbol symbol-75px">
                                    <img src="{{ Storage::url('icons/railway/soon.png') }}" class="w-50px h-50px" alt>
                                </span>
                                <span class="fs-semibold fs-3">Contenue de la version</span>
                                <span class="noReadVersion"></span>
                            </button>
                        </div>
                    </div>
                </div>
            </div>
            <div
                class="d-flex flex-column justify-content-between align-items-center w-15 shadow-lg bg-gray-600 bg-opacity-75"
                style="border-top-right-radius: 2rem; border-bottom-right-radius: 2rem">
                <div class="d-flex align-items-start h-25 justify-content-start">
                    <a href="" id="drawer_user_menu_close">
                        <i class="fa-regular fa-xmark-circle fs-2x text-white text-hover-gray-800 pt-5"></i>
                    </a>
                </div>
                <div class="d-flex flex-column h-50 rounded-2">
                    <a href="{{ route('account.mailbox.inbox') }}" class="mb-5 position-relative">
                        <i class="fa-solid fa-envelope fs-2x text-white text-hover-gray-800"></i>
                        @if($countMessage > 0)
                            <span class="badge badge-sm badge-circle badge-danger position-absolute top-0 start-100 translate-middle"><i class="fa-solid fa-exclamation text-white"></i> </span>
                        @endif
                    </a>
                    <a href="{{ route('news') }}" class="mb-5 position-relative">
                        <i class="fa-solid fa-bullhorn fs-2x text-white text-hover-gray-800"></i>
                        <span id="badgeNews"></span>
                    </a>
                    <div>
                        <a class="mb-5 position-relative" data-kt-menu-trigger="click" data-kt-menu-placement="left" data-kt-menu-offset="30px, 30px">
                            <i class="fa-solid fa-sun fs-2x text-white text-hover-gray-800"></i>
                        </a>
                        <div class="menu menu-sub menu-sub-dropdown menu-column menu-rounded menu-gray-800 menu-state-bg-light-primary fw-semibold w-auto min-w-200 mw-300px" data-kt-menu="true" data-kt-element="theme-mode-menu">
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="light">
														<span class="menu-icon" data-kt-element="icon">
															<i class="ki-outline ki-night-day fs-2"></i>
														</span>
                                    <span class="menu-title">Light</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="dark">
														<span class="menu-icon" data-kt-element="icon">
															<i class="ki-outline ki-moon fs-2"></i>
														</span>
                                    <span class="menu-title">Dark</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                            <!--begin::Menu item-->
                            <div class="menu-item px-3 my-0">
                                <a href="#" class="menu-link px-3 py-2" data-kt-element="mode" data-kt-value="system">
														<span class="menu-icon" data-kt-element="icon">
															<i class="ki-outline ki-screen fs-2"></i>
														</span>
                                    <span class="menu-title">System</span>
                                </a>
                            </div>
                            <!--end::Menu item-->
                        </div>
                    </div>
                </div>
                <div class="d-flex align-items-end h-25 justify-content-end">
                    <a href="{{ route('auth.logout') }}">
                        <i class="fa-solid fa-power-off fs-2x text-white text-hover-gray-800 pb-5"></i>
                    </a>
                </div>
            </div>
        </div>
    </div>
    <div id="drawer_bug_tracker"
        class="bg-white"
        data-kt-drawer="true"
         data-kt-drawer-activate="true"
         data-kt-drawer-toggle="#drawer_bug_tracker_button"
         data-kt-drawer-close="#drawer_bug_tracker_close"
         data-kt-drawer-width="800px"
         wire:ignore.self
         >
        <div class="card shadow-sm w-100">
            <form action="" wire:submit="sendBug" method="POST">
                <div class="card-header">
                    <h3 class="card-title">Support Technique</h3>
                    <div class="card-toolbar">
                        <a href="" id="drawer_bug_tracker_close">
                            <i class="fa-regular fa-xmark-circle fs-2x text-light text-hover-gray-800 pt-5"></i>
                        </a>
                    </div>
                </div>
                <div class="card-body">
                    <div class="mb-10">
                        <label for="ticket_category_id" class="form-label required">Catégorie de votre rapport</label>
                        <select wire:model="ticket_category_id" name="ticket_category_id" id="ticket_category_id" class="form-select" required>
                            <option>-- Sélectionner une catégorie --</option>
                            @foreach($service->ticket_categories as $category)
                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                            @endforeach
                        </select>
                    </div>
                    <x-form.input
                        name="subject"
                        label="Sujet de votre rapport"
                        required="true" />
                    <x-form.textarea
                        name="message"
                        label="Quel est le problème que vous rencontrer ?"
                        required="true"
                        :livewire="true" />
                </div>
                <div class="card-footer">
                    <button type="submit" class="btn btn-outline btn-outline-primary" wire:loading.attr="disabled">
                        <span wire:loading.remove><i class="fa-solid fa-check me-2"></i> Envoyer</span>
                        <span wire:loading wire:loading.class="spinner-grow spinner-grow-sm"></span>
                        <span wire:loading role="status">Envoie en cours...</span>
                    </button>
                </div>
            </form>
        </div>
    </div>
    <div id="drawer_version"
        class="bg-body"
        data-kt-drawer="true"
         data-kt-drawer-activate="true"
         data-kt-drawer-toggle="#drawer_version_button"
         data-kt-drawer-close="#drawer_version_close"
         data-kt-drawer-width="100%"
         wire:ignore.self
         >
        <div class="card shadow-sm w-100">
            <div class="card-header">
                <h3 class="card-title">Note de mise à jour {{ $service->latest_version->version }} ({{ \Carbon\Carbon::parse($service->latest_version->published_at)->format('d-m-Y') }})</h3>
                <div class="card-toolbar">
                    <a href="" id="drawer_version_close">
                        <i class="fa-regular fa-xmark-circle fs-2x text-light text-hover-gray-800 pt-5"></i>
                    </a>
                </div>
            </div>
            <div class="card-body">
                <x-markdown>
                    {!! $service->latest_version->contenue !!}
                </x-markdown>
            </div>
        </div>
    </div>
</div>

@section('scripts')
    <script>
        let articles = @json($articles);

        if (!localStorage.getItem('articles')) {
            let articlesStatus = articles.map(article => ({id: article.id, read: false}));
            localStorage.setItem('articles', JSON.stringify(articlesStatus));
        }

        let storedArticles = JSON.parse(localStorage.getItem('articles')) || [];
        let unreadArticles = storedArticles.filter(article => article.read === false);

        if(unreadArticles.length > 0) {
            console.log("News Non Lu")
            document.querySelector('#badgeNews').innerHTML = `<span class="badge badge-sm badge-circle badge-danger position-absolute top-0 start-100 translate-middle"><i class="fa-solid fa-exclamation text-white"></i> </span>`
            document.querySelector('#unreadBull').innerHTML = `<span class="badge badge-sm badge-circle badge-danger position-absolute top-0 start-100 translate-middle"><i class="fa-solid fa-exclamation text-white"></i> </span>`
        }

        function markAllAsRead() {
            storedArticles = storedArticles.map(article => ({id: article.id, read: true}));
            localStorage.setItem('articles', JSON.stringify(storedArticles));
        }
    </script>
@endsection
