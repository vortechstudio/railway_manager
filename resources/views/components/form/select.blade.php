<div class="mb-10" wire:ignore.self>
    @if(!$noLabel)
    <label for="{{ $name }}" class="form-label {{ $required ? 'required' : '' }}">{{ $label }}</label>
    @endif
    @if($selectType == 'select2')
        <select id="{{ $name }}" wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}" class="form-select" data-control="select2" data-placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}">
            <option></option>
            @foreach($options as $option)
                <option value="{{ $option['id'] }}" {{ $value == $option['id'] ? 'selected' : '' }}>{{ $option['value'] }}</option>
            @endforeach
        </select>
    @elseif($selectType == 'selectpicker')
        <select id="{{ $name }}" wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}" class="form-select selectpicker" data-live-search="true" data-placeholder="{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}">
            <option></option>
            @foreach($options as $option)
                <option value="{{ $option['id'] }}" {{ $value == $option['id'] ? 'selected' : '' }}>{{ $option['value'] }}</option>
            @endforeach
        </select>
    @else
        <select id="{{ $name }}" wire:model.prevent="{{ $isModel ? $model.'.'.$name : $name }}" class="form-select">
            <option>{{ $required && $noLabel ? ($placeholder ? $placeholder.'*' : $label.'*') : ($placeholder ? $placeholder : $label) }}</option>
            @foreach($options as $option)
                <option value="{{ $option['id'] }}" {{ $value == $option['id'] ? 'selected' : '' }}>{{ $option['value'] }}</option>
            @endforeach
        </select>
    @endif
    <span class="text-muted">{{ $hint }}</span>
</div>

@if($selectType == 'selectpicker')
    @push("scripts")
        <script type="text/javascript">
            $("{{ $name }}").selectpicker()
        </script>
    @endpush
@endif

@if($selectType == 'select2')
    @push("scripts")
        <script type="text/javascript">
            $("#{{ $name }}").on('change', e => {
                let data = $("#{{ $name }}").select2("val")
                @this.set('{{ $name }}', data)
            })
        </script>
    @endpush
@endif
