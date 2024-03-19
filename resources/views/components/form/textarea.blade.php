@if($type == 'simple')
    <div class="mb-10">
        @if(!$noLabel)
            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
        @endif
        <textarea
            class="form-control {{ $class }} @error("$name") is-invalid @enderror"
            wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}"
            id="{{ $name }}"
            name="{{ $name }}"
            placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}"
            value="{{ $value }}">{{ $value }}</textarea>

    </div>
@endif

@if($type == 'ckeditor')
    <div class="mb-10" wire:ignore>
        @if(!$noLabel)
            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
        @endif
        <div wire:ignore>
            <textarea
                class="form-control {{ $class }} @error("$name") is-invalid @enderror"
                wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}"
                id="{{ $name }}"
                name="{{ $name }}"
                placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}"
                value="{{ $value }}">{{ $value }}</textarea>
        </div>

    </div>
    @push('scripts')
        <script src="{{ asset('/plugins/custom/ckeditor/ckeditor-classic.bundle.js') }}"></script>
        <script type="text/javascript">
            ClassicEditor
                .create(document.querySelector('#{{ $name }}'))
                .then(editor => {
                    editor.model.document.on('change:data', () => {
                        @this.set("{{ $name }}", editor.getData())
                    })
                })
                .catch(error => {
                    console.error(error);
                });
        </script>

    @endpush
@endif

@if($type == 'tinymce')
    <div class="mb-10" wire:ignore>
        @if(!$noLabel)
            <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
        @endif
        <div wire:ignore>
            <textarea
                class="form-control {{ $class }} @error("$name") is-invalid @enderror"
                wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}"
                id="{{ $name }}"
                name="{{ $name }}"
                placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}"
                value="{{ $value }}">{{ $value }}</textarea>
        </div>

    </div>

    @push("scripts")
        <script src="{{ asset('/plugins/custom/tinymce/tinymce.bundle.js') }}"></script>
        <script type="text/javascript">
            let options = {
                selector: "#{{ $name }}",
                height: "480",
                plugins: 'print preview paste importcss searchreplace autolink autosave save directionality code visulablocks visualchars fullscreen image link media template codesample table charmap hr pagebreak nonbreaking anchor toc inserdatetime advlist lists wordcount imagetools textpattern noneditable help charmap quickbars emoticons',
                menubar: 'file edit view insert format tools table help',
                toolbar: 'undo redo | bold italic underline strikethrough | fontselect fontsizeselect formatselect | alignleft aligncenter alignright alignjustify | outdent indent | numlist bullist | forecolor backcolor removeformat | pagebreak | charmap emoticons | fullscreen preview save print | insertfile image media template link anchor codesample'
            }

            if ( KTThemeMode.getMode() === "dark" ) {
                options["skin"] = "oxide-dark";
                options["content_css"] = "dark";
            }
            tinymce.init(options);
        </script>
    @endpush
@endif
