<?php

namespace App\Jobs;

use App\Models\User\Railway\UserRailwayDelivery;
use App\Notifications\SendMessageAdminNotification;
use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class DeliveryJob implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    public function __construct(public UserRailwayDelivery $delivery)
    {
    }

    public function handle(): void
    {
        $model = $this->delivery->model::find($this->delivery->model_id);
        $model->update([
            'active' => true,
        ]);
        $this->delivery->user->notify(new SendMessageAdminNotification(
            title: 'Livraison effectuer',
            sector: 'delivery',
            type: 'success',
            message: "Livraison: {$this->delivery->designation} effectuer !"
        ));
        $this->delivery->delete();
    }
}
