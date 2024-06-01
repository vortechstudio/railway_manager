<?php

namespace App\Services\Models\Railway\Core;

use App\Models\Railway\Config\RailwayLevelReward;
use App\Models\Railway\Core\Message;

class RailwayLevelRewardAction
{
    public function __construct(private RailwayLevelReward $reward)
    {
    }

    public function rewarding()
    {
        $message = Message::create([
            'message_subject' => 'Nouvelle récompense de niveau',
            'message_content' => $this->messageContent(),
            'message_type' => 'account',
            'service_id' => 2,
        ]);
        $message->rewards()->create([
            'reward_type' => $this->reward->type,
            'reward_value' => $this->reward->action_count,
            'message_id' => $message->id,
        ]);
    }

    public function messageContent()
    {
        ob_start();
        ?>
        <span class="fw-bold">Cher directeur,</span>
        <p>Vous venez de passer au niveau supérieur, veuillez récupérer votre récompense pour vos efforts au maintients de vos infrastructures</p>
        <?php
        return ob_get_clean();
    }
}
