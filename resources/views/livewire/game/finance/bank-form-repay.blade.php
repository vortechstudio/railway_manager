<div>
    <form action="" wire:submit="repay">
        <div class="card shadow-sm">
            <div class="card-header">
                <h3 class="card-title">Remboursement de l'emprunt N°{{ $emprunt->number }}</h3>
                <div class="card-toolbar">
                    <button type="submit" class="btn btn-sm btn-success" wire:target="save" wire:loading.attr="disabled">
                        <span wire:loading.class="d-none" wire:target="save">Valider</span>
                        <span class="d-none" wire:loading.class.remove="d-none" wire:target="save"><i class="fa-solid fa-spinner fa-spin"></i> Validation en cours...</span>
                    </button>
                </div>
            </div>
            <div class="card-body">
               <div class="d-flex flex-column w-40 mb-5">
                   <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-1 p-5 mb-1">
                       <span>Somme Empruntée:</span>
                       <span class="fw-semibold">{{ Helpers::eur($emprunt->amount_emprunt - $emprunt->charge) }}</span>
                   </div>
                   <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-1 p-5 mb-1">
                       <span>Taux Actuel:</span>
                       <span class="fw-semibold">{{ $emprunt->taux_emprunt }} %</span>
                   </div>
                   <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-1 p-5 mb-1">
                       <span>Charges financières:</span>
                       <span class="fw-semibold">{{ Helpers::eur($emprunt->charge) }}</span>
                   </div>
                   <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-1 p-5 mb-1">
                       <span>Emprunt Total:</span>
                       <span class="fw-semibold">{{ Helpers::eur($emprunt->amount_emprunt) }}</span>
                   </div>
                   <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-1 p-5 mb-1">
                       <span>Somme Remboursée:</span>
                       <span class="fw-semibold">{{ Helpers::eur($amount_repay) }}</span>
                   </div>
                   <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-1 p-5 mb-1">
                       <span>Remboursement hebdomadaire:</span>
                       <span class="fw-semibold">{{ Helpers::eur($emprunt->amount_hebdo) }}</span>
                   </div>
                   <div class="d-flex justify-content-between align-items-center bg-gray-100 rounded-1 p-5 mb-1">
                       <span>Echéance:</span>
                       <span class="fw-semibold">{{ $emprunt->date->addWeeks($emprunt->duration)->format('d/m/Y') }}</span>
                   </div>
               </div>
                <x-base.title title="Remboursement" />
                <div class="form-check mb-2">
                    <input class="form-check-input" type="radio" name="typeRepay" wire:model="typeRepay" value="all" id="typeRepayAll" />
                    <label class="form-check-label" for="typeRepayAll">
                        Remboursé la totalité de l'emprunt: <strong>{{ Helpers::eur($amount_du) }}</strong>
                    </label>
                </div>
                <div class="form-check">
                    <input class="form-check-input" type="radio" name="typeRepay" wire:model="typeRepay" value="partial" id="typeRepayPartial" />
                    <label class="form-check-label" for="typeRepayPartial">
                        Remboursé une partie de l'emprunt:
                        <input type="text" class="form-control" id="amount_by_repay" name="amount_by_repay" wire:model="amount_by_repay" />
                    </label>
                </div>
            </div>
        </div>
    </form>
</div>
