<div>
    @if($paginator->hasPages())
        <ul class="pagination">
            @if($paginator->onFirstPage())
                <li class="page-item previous disabled">
                    <span class="page-link page-text">@lang('pagination.previous')</span>
                </li>
            @else
                <li class="page-item previous">
                    <a wire:click="previousPage" wire:loading.attr="disabled" class="page-link page-text">@lang('pagination.previous')</a>
                </li>
            @endif
            @foreach($elements as $element)
                @if(is_string($element))
                    <li class="page-item "><a  href="#" class="page-link">...</a></li>
                @endif
                @if(is_array($element))
                    @foreach($element as $page => $url)
                        @if($page == $paginator->currentPage())
                            <li wire:key="paginator-page-{{ $page }}" class="page-item active"><a href="#" class="page-link">{{ $page }}</a></li>
                        @else
                            <li wire:key="paginator-page-{{ $page }}" class="page-item "><a wire:click="gotoPage({{ $page }})" class="page-link">{{ $page }}</a></li>
                        @endif
                    @endforeach
                @endif
            @endforeach
            @if($paginator->hasMorePages())
                <li class="page-item next">
                    <a wire:click="nextPage" wire:loading.attr="disabled" class="page-link page-text">@lang('pagination.next')</a>
                </li>
            @else
                <li class="page-item next disabled">
                    <span class="page-link page-text">@lang('pagination.next')</span>
                </li>
            @endif
        </ul>
    @endif
</div>
