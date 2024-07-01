<div class="card shadow-sm mb-5">
    <div class="card-header">
        <h3 class="card-title">Résumé financier</h3>
    </div>
    <div class="card-body">
        <div class="row">
            <div class="col-6">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Valorisation</span>
                    <span>{{ Helpers::eur(auth()->user()->railway_company->valorisation) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Bénéfices Hebdomadaires des trajets</span>
                    <span>{{ Helpers::eur($benefice_ligne) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Trésorerie Structurel J-1</span>
                    <span>{{ Helpers::eur($tresorerie_structurel) }}</span>
                </div>
            </div>
            <div class="col-6">
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Dernier impôt prélevé</span>
                    <span>{{ Helpers::eur($latest_impot) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Frais de location Hebdomadaire</span>
                    <span>{{ Helpers::eur($locHebdo) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Remboursement Hebdomadaire</span>
                    <span>{{ Helpers::eur($rembHebdo) }}</span>
                </div>
                <div class="d-flex justify-content-between align-items-center mb-2">
                    <span>Somme total à rembourser</span>
                    <span>{{ Helpers::eur($totalRemb) }}</span>
                </div>
            </div>
        </div>
    </div>
</div>
