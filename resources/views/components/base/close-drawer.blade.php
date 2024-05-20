<script type="text/javascript">
    window.addEventListener('closeDrawer', (event) => {
        const drawerId = event.detail[0];

        const drawer = KTDrawer.getInstance(document.getElementById(drawerId))
        drawer.hide()
    })
</script>
