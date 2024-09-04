<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Actions;

use Omniax\basement_chatBot\Contracts\SendPrivateMessage as SendPrivateMessageContract;
use Omniax\basement_chatBot\Data\PrivateMessageData;
use Omniax\basement_chatBot\Events\PrivateMessageReceived;
use Omniax\basement_chatBot\Events\PrivateMessageSent;
use Omniax\basement_chatBot\Facades\Basement;

class SendPrivateMessage implements SendPrivateMessageContract
{
    /**
     * Send a private message to the receiver.
     */
    public function send(PrivateMessageData $privateMessage): PrivateMessageData
    {
        $createdMessage = Basement::newPrivateMessageModel()->create([
            'receiver_id' => $privateMessage->receiver_id,
            'sender_id' => $privateMessage->sender_id,
            'type' => $privateMessage->type,
            'value' => $privateMessage->value,
        ]);

        $privateMessage->id = $createdMessage->id;
        $privateMessage->created_at = $createdMessage->created_at;
        $privateMessage->read_at = $createdMessage->read_at;

        broadcast(new PrivateMessageSent($privateMessage));

        if ($privateMessage->receiver_id !== $privateMessage->sender_id) {
            broadcast(new PrivateMessageReceived($privateMessage));
        }

        return $privateMessage;
    }
}
