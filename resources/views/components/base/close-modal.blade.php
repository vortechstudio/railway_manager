<script type="text/javascript">
    window.addEventListener('closeModal', (event) => {
        const modalId = event.detail[0];

        const modal = document.getElementById(modalId);
        modal.classList.remove('show')
        modal.setAttribute('aria-hidden', 'true')
        modal.setAttribute('style', 'display: none')

        const modalsBackdrops = document.getElementsByClassName('modal-backdrop');
        document.body.removeChild(modalsBackdrops[0]);
    })
</script>
