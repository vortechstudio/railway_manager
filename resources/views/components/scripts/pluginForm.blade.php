@push("scripts")
    <script>
        document.addEventListener('livewire:init', () => {
            document.querySelectorAll('[data-control="time"]').forEach(input => {
                let el = $(`#${input.getAttribute('id')}`);
                initTime();

                el.on('change', function (e) {
                    console.log(`id: ${input.getAttribute('id')}, value: ${el.val()}`);
                    @this.set(`${input.getAttribute('id')}`, el.val())
                })

                function initTime() {
                    el.flatpickr({
                        enableTime: true,
                        noCalendar: true,
                        dateFormat: "H:i",
                    });
                }
            })
            document.querySelectorAll('[data-control="select2"]').forEach(select => {
                console.log(select.getAttribute('id'))
                let el = $(`#${select.getAttribute('id')}`)
                initSelect()

                el.on('change', function (e) {
                    @this.set(select.getAttribute('id'), el.select2('val'))
                })

                function initSelect () {
                    el.select2({
                        placeholder: '{{__('Select your option')}}',
                        allowClear: !el.attr('required'),
                    })
                }
            })
            document.querySelectorAll('[data-control="uiSlider"]').forEach(slider => {
                noUiSlider.create(slider, {
                    start: [0],
                    tooltips: [true],
                    step: parseInt(slider.dataset.pan),
                    range: {
                        "min": parseInt(slider.dataset.min),
                        "max": parseInt(slider.dataset.max)
                    }
                })

                slider.noUiSlider.on('set', values => {
                    Livewire.dispatch(`${slider.getAttribute('id')}Updated`, values)
                })

            })
        })
    </script>
@endpush
