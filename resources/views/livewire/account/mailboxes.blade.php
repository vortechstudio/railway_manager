<div>
    @if(count($messages) > 0)
        <div class="row">
            <div class="col-sm-12 col-lg-4 mb-12 h-500px">
                <ul class="d-flex flex-column h-100 nav nav-tabs hover-scroll-y">
                    @foreach($messages as $k => $message)
                        <li class="nav-item {{ $message->is_read ? 'opacity-50' : '' }} w-100">
                            <a wire:click.prevent="read({{ $message->id }})" href="#message_{{ $k }}" class="nav-link min-h-100px p-5 bg-active-primary {{ $selectedMessage == $message->id ? 'active' : '' }}" data-bs-toggle="tab">
                            <span class="d-flex flex-row justify-content-between align-items-center ">
                                <span class="d-flex flex-column">
                                    <span class="fs-2 fw-bold">{{ $message->message->message_subject }}</span>
                                    <span class="fs-6 text-muted">{{ $message->created_at->diffForHumans() }}</span>
                                </span>
                                @if(!empty($message->reward_type))
                                    <span class="d-flex flex-grow-0 border border-2 border-primary border-active-info rounded-3 p-2">
                                        <span class="symbol symbol-70px">
                                            <img src="{{ Storage::url('icons/railway/'.$message->reward_type->value.'.png') }}" alt="">
                                            @if($message->reward_collected)
                                                <span class="symbol-badge badge badge-circle badge-light start-100">
                                                    <i class="fa-solid fa-check text-success"></i>
                                                </span>
                                            @endif
                                        </span>
                                    </span>
                                @endif
                            </span>
                            </a>
                        </li>
                    @endforeach
                </ul>
                <button wire:click="allDelete" wire:confirm="Supprimer tous les messages ?" class="btn btn-outline btn-outline-dark"><i class="fa-solid fa-xmark-circle"></i> Supprimer tous les messages</button>
            </div>
            <div class="col-sm-12 col-lg-8 mb-12">
                <div class="tab-content">
                    @foreach($messages as $k => $message)
                        <div class="tab-pane fade {{ $selectedMessage == $message->id ? 'show active' : '' }}" id="message_{{ $k }}" role="tabpanel">
                            <div class="card shadow-sm">
                                <div class="card-header">
                                    <h3 class="card-title">{{ $message->message->message_subject }}</h3>
                                    <div class="card-toolbar">
                                        @if(isset($message->reward_type) && !$message->reward_collected)
                                            <button wire:click="claim({{ $message->id }})" type="button" class="btn btn-sm btn-light">
                                                Réclamer
                                            </button>
                                        @endif
                                    </div>
                                </div>
                                <div class="card-body">
                                    <x-markdown>
                                        {!! $message->message->message_content !!}
                                    </x-markdown>
                                </div>
                                @if($message->reward_type)
                                    <div class="card-footer">
                                        <div class="d-flex flex-column align-items-center justify-content-center">
                                            <div class="symbol symbol-100px symbol-circle mb-2">
                                                <img src="{{ Storage::url('icons/railway/'.$message->reward_type->value.'.png') }}" alt="">
                                                @if($message->reward_collected)
                                                    <span class="symbol-badge badge badge-circle badge-light start-100">
                                                    <i class="fa-solid fa-check text-success"></i>
                                                </span>
                                                @endif
                                            </div>
                                            <span class="badge badge-lg badge-light">{{ number_format($message->reward_value, 0, ',', ' ') }}</span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>
                    @endforeach
                </div>
            </div>
        </div>
    @else
        <x-base.is-null
            text="Aucun message disponible actuellement" />
    @endif
</div>
