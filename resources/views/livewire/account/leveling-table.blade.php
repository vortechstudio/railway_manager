<div class="d-flex flex-wrap justify-content-center align-items-center w-100 gap-5">
    @foreach(\App\Models\Railway\Config\RailwayLevel::where('id', '!=' , 0)->get() as $level)
        @if(!$user->railway_rewards()->where('model', \App\Models\Railway\Config\RailwayLevelReward::class)->where('model_id', $level->reward->id)->exists())
            <a class="card shadow-sm w-20 h-400px @if($level->id > $user->railway->level) bg-gray-600 opacity-50 @endif border border-3 border" @if($level->id <= $user->railway->level) disabled  wire:click="claim({{ $level->id }})" @endif >
                <div class="card-body d-flex flex-column justify-content-center align-items-center m-auto">
                    <div class="symbol symbol-200px position-relative" >
                        <img src="{{ Storage::url('icons/railway/star.png') }}" alt="">
                        <div class="d-flex rounded-circle w-50px h-50px justify-content-center align-items-center bg-white shadow-sm position-absolute top-50 start-50 translate-middle border border-3 border-danger">
                            <span class="fs-3x">{{ $level->id }}</span>
                        </div>
                    </div>
                </div>
                <div class="card-footer">
                    <div class="d-flex flex-center">
                        <div class="symbol symbol-50px position-relative">
                            <img src="{{ Storage::url("services/{$service->id}/game/icons/leveling/{$level->reward->type->value}.png") }}" alt="">
                            <span class="position-absolute badge bg-gray-200 top-100 start-100">{{ $level->reward->action_count }}</span>
                        </div>
                    </div>
                </div>
            </a>
        @endif
    @endforeach
</div>

