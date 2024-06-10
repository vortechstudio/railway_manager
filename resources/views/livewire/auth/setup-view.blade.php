<form action="" wire:submit="save">

    <div class="row g-3 mb-9">
        <div class="col-12">
            <div class="mb-10">
                <label class="form-label required">Mot de passe</label>
                <div class="input-group">
                    <input type="{{ $visible ? 'text' : 'password' }}" id="password" wire:model.live.debounce="password" class="form-control">
                    <button class="btn btn-outline-secondary" type="button" wire:click="$toggle('visible')">
                        <!-- Heroicon name: solid/eye-off -->
                        @if($visible)
                            <i class="fa-solid fa-eye fs-4"></i>
                        @else
                            <i class="fa-solid fa-eye-slash fs-4"></i>
                        @endif
                    </button>
                </div>
                <span class="font-weight-bold">Force du mot de passe:</span> {{ $strengthLevels[$strengthScore] ?? 'Faible' }}
                <progress value="{{ $strengthScore }}" max="4" class="w-100"></progress>
            </div>

            <div class="separator my-3"></div>

            <x-base.title title="Configuration de votre espace" />

            <div class="mb-10">
                <label class="form-label">Nom de votre compagnie</label>
                <input type="text" id="name_company" name="name_company" class="form-control" wire:model="name_company"/>
            </div>
            <div class="mb-10">
                <label class="form-label">Nom de votre secrétaire</label>
                <input type="text" id="name_secretary" name="name_secretary" class="form-control" wire:model="name_secretary"/>
            </div>
            <div class="mb-10">
                <label class="form-label">Description de votre compagnie</label>
                <textarea id="desc_company" name="desc_company" wire:model="desc_company" class="form-control"></textarea>
            </div>
            <x-form.checkbox
                name="tos"
                value="1"
                label="J'accepte les conditions générales d'utilisations de Railway Manager"
                required="true" />

            <button type="submit" class="btn btn-primary w-100" wire:loading.attr="disabled" wire:target="save">
                <span wire:loading.class="d-none" wire:target="save">Valider</span>
                <span class="d-none" wire:loading.class.remove="d-none" wire:target="save"><i class="fa-solid fa-spinner fa-spin"></i> Création du compte en cours...</span>
            </button>
        </div>
    </div>
</form>
