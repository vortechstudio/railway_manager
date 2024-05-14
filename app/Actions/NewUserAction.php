<?php

namespace App\Actions;

use App\Models\Railway\Core\Message;
use App\Services\RailwayService;

class NewUserAction
{
    public function insertNewsMessageAccount()
    {
        $service = (new RailwayService())->getRailwayService();
        foreach (Message::where('service_id', $service->id)->where('message_type', 'global')->get() as $message) {
            $previous = $message->railway_messages()->where('message_id', $message->id)->first();
            $message->railway_messages()->create([
                'message_id' => $message->id,
                'user_id' => auth()->user()->id,
                'reward_type' => $previous->reward_type,
                'reward_value' => $previous->reward_value,
            ]);
        }
    }
}
