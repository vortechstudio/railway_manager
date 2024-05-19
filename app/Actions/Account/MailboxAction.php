<?php

namespace App\Actions\Account;

use App\Models\Railway\Core\Message;
use App\Models\User\User;
use App\Services\RailwayService;

class MailboxAction
{
    /**
     * Adds the specified value to the user's railway argent.
     *
     * @param int $value The value to be added to the railway argent.
     * @return void
     */
    public function addArgent(int $value)
    {
        auth()->user()->railway->argent += $value;
        auth()->user()->railway->save();
    }

    /**
     * Adds Tpoint to the user's railway.
     *
     * @param int $value The value to add to the user's Tpoint.
     * @return void
     */
    public function addTpoint(int $value)
    {
        auth()->user()->railway->tpoint += $value;
        auth()->user()->railway->save();
    }

    /**
     * Creates a new message and associates it with a user.
     *
     * @param User $user The user to associate the message with.
     * @param string $subject The subject of the message.
     * @param string $message The content of the message.
     * @param string $type The type of the message (default: 'global').
     * @param string|null $reward_type The type of reward associated with the message (optional).
     * @param int|null $reward_value The value of the reward associated with the message (optional).
     * @return void
     */
    public function newMessage(User $user, string $subject, string $message, string $type = 'global', ?array $rewards = [])
    {
        $service = (new RailwayService())->getRailwayService();
        \DB::transaction(function () use ($subject, $message, $type, $service, $user, $rewards) {
            $message = Message::create([
                'message_subject' => $subject,
                'message_content' => $message,
                'message_type' => $type,
                'service_id' => $service->id
            ]);
            foreach ($rewards as $k => $reward) {
                $message->rewards()->create([
                    'reward_type' => $reward['type'],
                    'reward_value' => $reward['value'],
                    'message_id' => $message->id
                ]);
            }

            $message->railway_messages()->create([
                'user_id' => $user->id,
                'message_id' => $message->id,
            ]);
        });
    }
}
