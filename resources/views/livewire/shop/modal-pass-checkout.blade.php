<div>
    <div class="modal bg-dark bg-opacity-75 animate__animated animate__flipInX" tabindex="-1" id="modalPassCheckout">
        <div class="modal-dialog modal-dialog-centered modal-xl">
            <div class="modal-content bg-opacity-0">
                <div class="d-flex flex-column justify-content-center align-items-center bg-dark bg-gradient bg-opacity-0">
                    <img src="{{ Storage::url('icons/railway/delivery-check.png') }}" class="w-100px img-fluid" alt="">
                    <span class="text-orange-700 fs-2tx fw-bold">Objets Obtenues</span>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center bg-dark bg-opacity-75 p-10 animate__animated animate__zoomIn animate__delay-1s">
                    <div class="symbol symbol-100px animate__animated animate__zoomIn animate__delay-2s">
                        <div class="symbol-label" style="background: url('{{ Storage::url('icons/railway/shop/rarity/shop_argent.png') }}')">
                            <img src="{{ Storage::url('icons/railway/shop/category/bonus.png') }}" class="w-90px" alt="">
                            <div class="symbol-badge badge rounded-1 badge-lg badge-primary start-100 top-100">100 000</div>
                        </div>
                    </div>
                </div>
                <div class="d-flex flex-column justify-content-center align-items-center bg-dark bg-gradient bg-opacity-0 animate__animated animate__fadeInRight animate__delay-2s">
                    <p class="fw-bold fs-1 text-white top-100 start-100">Toucher l'écran pour continuer</p>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        window.addEventListener('showModalPassCheckout', (event) => {
            console.log(event)
            const modalId = event.detail[0].id
            const modal = new bootstrap.Modal(document.getElementById(modalId))

            document.getElementById(modalId).querySelector('.symbol-label').innerHTML = `
                <img src="${event.detail[0].item.image}" class="w-90px" alt="">
                <div class="symbol-badge badge rounded-1 badge-lg badge-primary start-100 top-100">${event.detail[0].item.blocked_max}</div>
                `
            document.getElementById(modalId).querySelector('.symbol-label').style.background = `{{ Storage::url('icons/railway/shop/rarity/') }}${event.detail[0].item.rarity}.png'`

            modal.show()



        })
    </script>
@endpush
