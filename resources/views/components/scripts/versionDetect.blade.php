<script type="text/javascript">
    let version = @json($service->latest_version);
    let noReadElement = document.querySelector('.noReadVersion')

    function write() {
        if(!localStorage.getItem('latestVersion')) {
            localStorage.setItem('latestVersion', JSON.stringify({tag: version.version, read: false}));
            formattingCode()
        } else {
            if(JSON.parse(localStorage.getItem('latestVersion')).tag !== version.version) {
                localStorage.removeItem('latestVersion')
                localStorage.setItem('latestVersion', JSON.stringify({tag: version.version, read: false}));
            }
            formattingCode()
        }
    }

    function formattingCode() {
        if(isRead() !== true) {
            if(noReadElement) {
                noReadElement.classList.add('position-absolute', 'top-0', 'start-100', 'translate-middle', 'badge', 'badge-circle', 'badge-danger');
                noReadElement.innerHTML = `<i class="fa-solid fa-exclamation text-white"></i>`
            }
        } else {
            if(noReadElement) {
                noReadElement.classList.remove('position-absolute', 'top-0', 'start-100', 'translate-middle', 'badge', 'badge-circle', 'badge-danger')
                noReadElement.innerHTML = ``
            }
        }
    }

    function isRead() {
        return JSON.parse(localStorage.getItem('latestVersion')).read
    }

    write()

    document.addEventListener('readVersion', () => {
        localStorage.setItem('latestVersion', JSON.stringify({tag: version.version, read: true}))
        formattingCode()
    })


</script>
