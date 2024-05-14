<div class="modal fade" tabindex="-1" id="modalReward">
    <div class="modal-dialog modal-dialog-centered modal-xl">
        <div class="modal-content">
            <div class="modal-body">
                <div class="d-flex flex-column justify-content-center align-items-center my-5">
                    <span class="fw-bold fs-4tx">Vous avez reçu une récompense !</span>
                    <div class="symbol symbol-150px border border-primary p-5 mb-2 animate__animated animate__flipInX animate__delay-1s">
                        <img class="modalImage" src="" alt="">
                    </div>
                    <span class="modalBadge badge badge-lg badge-light animate__animated animate__fadeInDown animate__delay-1s"></span>
                </div>
            </div>

            <div class="modal-footer">
                Veuillez cliquer pour fermer
            </div>
        </div>
    </div>
</div>

@push("scripts")
    <script type="text/javascript">
        window.addEventListener('showModalReward', (event) => {
            console.log(event)
            const modalId = event.detail[0].id
            const modal = new bootstrap.Modal(document.getElementById(modalId))

            document.getElementById(modalId).querySelector('.modalImage').setAttribute('src', `{{ Storage::url('icons/railway/') }}${event.detail[0].reward_type}.png`)
            document.getElementById(modalId).querySelector('.modalBadge').innerHTML = event.detail[0].reward_value

            modal.show()


        })
    </script>
@endpush
