<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Events;

use Omniax\basement_chatBot\Data\PrivateMessageData;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class PrivateMessageReceived implements ShouldBroadcastNow
{
    /**
     * The value of the private message sent.
     *
     * @var array<string,mixed>
     */
    public array $detail;

    /**
     * The message receiver id.
     */
    protected int $receiverId;

    /**
     * Create a new notification instance.
     */
    public function __construct(PrivateMessageData $message)
    {
        $this->receiverId = $message->receiver_id;
        $this->detail = $message->toArray();

        /** @var \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $sender */
        $sender = $message->sender;

        $this->detail['sender'] = $sender->only(['id', 'name', 'avatar']);
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'basement.message.received';
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): PresenceChannel|array
    {
        return new PresenceChannel('basement.contacts.' . $this->receiverId);
    }
}
