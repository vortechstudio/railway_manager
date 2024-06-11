<div>
    <div class="card shadow-sm animated-background h-auto text-white mb-5">
        <div class="card-body">
            <div class="d-flex justify-content-between">
                <div class="d-flex">
                    <div class="symbol symbol-100px me-3">
                        <img src="{{ auth()->user()->socials()->first()->avatar }}" alt="">
                    </div>
                    <span class="fs-2x fw-bolder">{{ auth()->user()->railway->name_company }}</span>
                </div>
                <div class="d-flex flex-row">
                    <div class="d-flex flex-column align-items-end">
                        <span class="fs-3 fw-semibold">Place:</span>
                        <span class="fs-1 fw-bold">{{ auth()->user()->railway->ranking }}</span>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="card shadow-sm bg-blue-grey-800 text-white">
        <div class="card-header">
            <h3 class="card-title">&nbsp;</h3>
            <div class="card-toolbar">
                <div class="position-relative w-250px me-3">
                    <i class="ki-duotone ki-magnifier fs-2 text-gray-500 position-absolute top-50 translate-middle-y ms-4"><span class="path1"></span><span class="path2"></span></i>
                    <input type="text" class="form-control border-gray-200 h-40px bg-body ps-13 fs-7" wire:model.live.debounce.500ms="search" placeholder="Rechercher une compagnie..." data-kt-search-element="input">
                </div>
                <select wire:model="perPage" class="form-select border-gray-200 h-40px bg-body ps-13 fs-7 w-100px me-5" id="perPage">
                    @foreach([50,100,250,500] as $value)
                        <option value="{{ $value }}">{{ $value }}</option>
                    @endforeach
                </select>
            </div>
        </div>
        <div class="card-body">
            <div class="table-responsive" wire:loading.class="opacity-50 bg-grey-700 table-loading">
                <div class="table-loading-message">
                    <span class="spinner-border spinner-border-sm align-middle me-2"></span> Chargement...
                </div>
                <table class="table table-row-bordered table-row-gray-300 shadow-lg bg-info text-light rounded-4 table-striped gap-5 gs-5 gy-5 gx-5 align-middle">
                    <thead>
                    <tr class="fw-bold fs-3">
                        <th>Place</th>
                        <th>Compagnie</th>
                        <th>Valorisation</th>
                        <th>Trésorerie Structurelle</th>
                    </tr>
                    </thead>
                    @if($users->count() == 0)
                        <tbody>
                        <tr>
                            <td colspan="7">
                                <x-base.is-null
                                    text="Aucun Classement disponible" />
                            </td>
                        </tr>
                        </tbody>
                    @else
                        <tbody>
                        @foreach($users as $user)
                            <tr @if($user['user_id'] == auth()->id()) class="scale-up bg-green-400" @endif>
                                <td class="text-center">{{ $user['ranking'] }}</td>
                                <td>{{ $user['name_company'] }}</td>
                                <td>{{ Helpers::eur(\App\Models\User\Railway\UserRailwayCompany::where('user_id', $user['user_id'])->first()->valorisation) }}</td>
                                <td>{{ Helpers::eur((new \App\Services\Models\User\Railway\UserRailwayCompanyAction(\App\Models\User\Railway\UserRailwayCompany::where('user_id', $user['user_id'])->first()))->getTresorerieStructurel(now()->subDays(7)->startOfDay(), now()->subDay()->endOfDay())) }}</td>
                            </tr>
                        @endforeach
                        </tbody>
                    @endif
                </table>
            </div>
        </div>
        <div class="card-footer">
            {{ $users->links() }}
        </div>
    </div>
</div>
