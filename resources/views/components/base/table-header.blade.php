<th wire:click="setOrderField('{{ $name }}')"
@if($visible)
    @if($direction === 'ASC')
    class="table-sort-asc"
    @else
    class="table-sort-desc"
    @endif
@endif
>
    {{ $slot }}
</th>
