<?php

declare(strict_types=1);

namespace BasementChat\Basement\Events;

use BasementChat\Basement\Data\PrivateMessageData;
use Illuminate\Broadcasting\PresenceChannel;
use Illuminate\Contracts\Broadcasting\ShouldBroadcastNow;

class PrivateMessageSent implements ShouldBroadcastNow
{
    /**
     * The value of the private message sent.
     *
     * @var array<string,mixed>
     */
    public array $detail;

    /**
     * The message sender id.
     */
    protected int $senderId;

    /**
     * Create a new notification instance.
     */
    public function __construct(PrivateMessageData $message)
    {
        $this->senderId = $message->sender_id;
        $this->detail = $message->toArray();

        /** @var \Illuminate\Foundation\Auth\User&\BasementChat\Basement\Contracts\User $sender */
        $sender = $message->sender;

        $this->detail['sender'] = $sender->only(['id', 'name', 'avatar']);
    }

    /**
     * The event's broadcast name.
     */
    public function broadcastAs(): string
    {
        return 'basement.message.sent';
    }

    /**
     * Get the channels the event should broadcast on.
     */
    public function broadcastOn(): PresenceChannel|array
    {
        return new PresenceChannel('basement.contacts.' . $this->senderId);
    }
}
