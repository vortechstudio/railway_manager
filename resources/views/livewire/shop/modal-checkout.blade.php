<div>
    <div class="modal fade" tabindex="-1" id="modalCheckout">
        <div class="modal-dialog modal-lg modal-dialog-centered">
            <div class="modal-content bg-bluegrey-600">
                <div class="modal-header">
                    <h3 class="modal-title text-white">Acheter l'objet</h3>

                    <!--begin::Close-->
                    <div class="btn btn-icon btn-sm btn-active-light-primary ms-2" data-bs-dismiss="modal" aria-label="Close">
                        <i class="ki-duotone ki-cross fs-1"><span class="path1"></span><span class="path2"></span></i>
                    </div>
                    <!--end::Close-->
                </div>

                <div class="modal-body">
                    <div class="row">
                        <div class="col-sm-12 col-lg-4 mb-5">
                            <img src="" class="img-fluid imgCheckout" alt="">
                        </div>
                        <div class="col-sm-12 col-lg-8 mb-5">
                            <div class="d-flex bg-white bg-opacity-50 rounded-1 p-2 mb-2">
                                <span class="fs-2 fw-bold nameCheckout"></span>
                            </div>
                            <div class="d-flex flex-wrap align-items-center gap-3">
                                <div class="symbol symbol-70px">
                                    <img src="" class="imgItemCheckout" alt="">
                                    <span class="symbol-badge bg-white badge badge-circle top-100 start-100 qteCheckout"></span>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="modal-footer">
                    <div class="d-flex justify-content-center btnCheckout">

                    </div>
                </div>
            </div>
        </div>
    </div>

    @push("scripts")
        <script type="text/javascript">
            window.addEventListener('showModalCheckout', (event) => {
                console.log(event)
                const modalId = event.detail[0].id
                const modal = new bootstrap.Modal(document.getElementById(modalId))

                document.getElementById(modalId).querySelector('.imgCheckout').setAttribute('src', event.detail[0].item.image)
                document.getElementById(modalId).querySelector('.imgItemCheckout').parentElement.classList.add('shop-bg-'+event.detail[0].item.rarity)
                document.getElementById(modalId).querySelector('.imgItemCheckout').setAttribute('src', event.detail[0].item.image)
                document.getElementById(modalId).querySelector('.nameCheckout').innerHTML = event.detail[0].item.name
                document.getElementById(modalId).querySelector('.qteCheckout').innerHTML = event.detail[0].item.qte

                if(event.detail[0].item.has_checkout) {
                    document.getElementById(modalId).querySelector('.btnCheckout').innerHTML = `
                        <button wire:click="passCheckout('${event.detail[0].item.id}')" wire:loading.attr="disabled" class="btn btn-lg btn-primary fs-2">
                        <span wire:loading.remove>${event.detail[0].item.price_format}</span>
                        <span wire:loading><i class="fa-solid fa-spinner fa-spin"></i> Veuillez patienter...</span>
                        </button>`
                } else {
                    document.getElementById(modalId).querySelector('.btnCheckout').innerHTML = `<button disabled="disabled" class="btn btn-lg btn-primary fs-2">${event.detail[0].item.price_format}</button>`
                }

                modal.show()



            })
        </script>
    @endpush

</div>
