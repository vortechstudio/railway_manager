<div>
    <div class="card shadow-sm">
        <div class="card-body">
            <div class="tree">
                <ul>
                    @foreach($categories as $category)
                        <li>
                            <a href="">{{ $category->name }}</a>
                            <ul>
                                @foreach($category->railwayResearches as $research)
                                    @if($research->parent_id == null)
                                        <li>
                                            <a @if($research->is_unlocked && $research->level > $research->current_level) wire:click="start({{ $research->id }})" @endif
                                                class="border border-2 {{ $research->is_unlocked ? 'border-success' : 'border-danger' }} {{ $research->is_unlocked ? 'hover-scale' : 'bg-gray-300' }}"
                                                data-bs-toggle="popover"
                                                data-bs-placement="right"
                                                data-bs-trigger="hover"
                                                data-bs-html="true"
                                                data-bs-custom-class="research-popover"
                                                data-bs-content="{{ (new \App\Services\Models\Railway\Research\RailwayResearchAction($research))->getPopoverContent() }}"
                                            >
                                                <span class="symbol symbol-75px position-relative">
                                                    <img src="{{ $research->image }}" class="research-icon" alt="{{ $research->name }}">
                                                    <span class="d-flex align-items-center position-absolute top-100 start-50 translate-middle levels">
                                                        @for ($i = 1; $i <= $research->level; $i++)
                                                            <div class="level-circle {{ $research->current_level >= $i ? 'checked' : 'unchecked' }}"></div>
                                                        @endfor
                                                    </span>
                                                </span>
                                            </a>
                                            @if($research->childrens->count() > 0)
                                                @livewire("game.research.research-tree-node", ['research' => $research])
                                            @endif
                                        </li>
                                    @endif
                                @endforeach
                            </ul>
                        </li>
                    @endforeach
                </ul>
            </div>
        </div>
    </div>
</div>
