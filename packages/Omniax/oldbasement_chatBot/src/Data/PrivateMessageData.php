<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Data;

use Omniax\basement_chatBot\Enums\MessageType;
use Omniax\basement_chatBot\Facades\Basement;
use Omniax\basement_chatBot\Models\PrivateMessage;
use Illuminate\Contracts\Support\Arrayable;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Carbon;
use Illuminate\Support\Collection;

/**
 * @property Authenticatable&\Omniax\basement_chatBot\Contracts\User $receiver
 * @property Authenticatable&\Omniax\basement_chatBot\Contracts\User $sender
 *
 * @implements Arrayable<string,mixed>
 */
class PrivateMessageData implements Arrayable
{
    protected \Closure $receiverResolver;

    protected \Closure $senderResolver;

    /**
     * Create a new private message data instance.
     *
     * @param (Authenticatable&\Omniax\basement_chatBot\Contracts\User)|null $receiver
     * @param (Authenticatable&\Omniax\basement_chatBot\Contracts\User)|null $sender
     */
    public function __construct(
        public int $receiver_id,
        public int $sender_id,
        public MessageType $type,
        public string $value,
        public ?int $id = null,
        public ?Carbon $created_at = null,
        public ?Carbon $read_at = null,
        Authenticatable|null $receiver = null,
        Authenticatable|null $sender = null,
    ) {
        $this->receiverResolver = function () use (&$receiver) {
            if ($receiver !== null) {
                return $receiver;
            }

            $receiver = Basement::newUserModel()->findOrFail($this->receiver_id);

            return $receiver;
        };

        $this->senderResolver = function () use (&$sender) {
            if ($sender !== null) {
                return $sender;
            }

            $sender = Basement::newUserModel()->findOrFail($this->sender_id);

            return $sender;
        };
    }

    public function __get(string $name): mixed
    {
        if ($name === 'receiver') {
            return ($this->receiverResolver)();
        }

        if ($name === 'sender') {
            return ($this->senderResolver)();
        }

        return null;
    }

    /**
     * Create data collection from given messages id.
     *
     * @param array<int> $messagesId
     * @param array<string> $with
     *
     * @return \Illuminate\Support\Collection<int,PrivateMessageData>
     */
    public static function collectionFromId(array $messagesId, array $with = []): Collection
    {
        $messages = Basement::newPrivateMessageModel()
            ->with($with)
            ->whereIn('id', $messagesId)
            ->get();

        return $messages->map(static fn (PrivateMessage $message): self => new self(
            receiver_id: (int) $message->receiver_id,
            sender_id: (int) $message->sender_id,
            type: $message->type,
            value: $message->value,
            id: (int) $message->id,
            created_at: $message->created_at,
            read_at: $message->read_at,
        ));
    }

    /**
     * Get the instance as an array.
     *
     * @return array<string,mixed>
     */
    public function toArray(): array
    {
        return [
            'receiver_id' => $this->receiver_id,
            'sender_id' => $this->sender_id,
            'type' => $this->type->value,
            'value' => $this->value,
            'id' => $this->id,
            'created_at' => $this->created_at?->toISOString(),
            'read_at' => $this->read_at?->toISOString(),
            'receiver' => $this->receiver->toArray(),
            'sender' => $this->sender->toArray(),
        ];
    }
}
