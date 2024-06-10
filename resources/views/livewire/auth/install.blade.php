<form action="" wire:submit="save">

    <div class="row g-3 mb-9">
        <div class="col-12">
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
