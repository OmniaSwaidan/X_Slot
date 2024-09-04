<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Actions;

use Omniax\basement_chatBot\Contracts\MarkPrivatesMessagesAsRead as MarkPrivatesMessagesAsReadContract;
use Omniax\basement_chatBot\Data\PrivateMessageData;
use Omniax\basement_chatBot\Events\PrivateMessagesReceivedMarkedAsRead;
use Omniax\basement_chatBot\Events\PrivateMessagesSentMarkedAsRead;
use Omniax\basement_chatBot\Facades\Basement;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

class MarkPrivatesMessagesAsRead implements MarkPrivatesMessagesAsReadContract
{
    /**
     * Mark given private messages as has been read.
     *
     * @param \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $readBy
     * @param \Illuminate\Support\Collection<int,\Omniax\basement_chatBot\Data\PrivateMessageData> $privateMessages
     *
     * @return \Illuminate\Support\Collection<int,\Omniax\basement_chatBot\Data\PrivateMessageData>
     */
    public function markAsRead(Authenticatable $readBy, Collection $privateMessages): Collection
    {
        $time = now();

        Basement::newPrivateMessageModel()
            ->whereIn('id', $privateMessages->pluck('id'))
            ->whereNull('read_at')
            ->update([
                'read_at' => $time,
            ]);

        $privateMessages->each(static function (PrivateMessageData $data) use ($time): void {
            $data->read_at = $time;
        });

        $this->notify(receiver: $readBy, privateMessages: $privateMessages);

        return $privateMessages;
    }

    /**
     * Notify the sender that the receiver has read private messages. This method also notifies
     * the receiver, so multiple tabs opened by the receiver will synchronize unread messages.
     *
     * @param \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $receiver
     * @param \Illuminate\Support\Collection<int,\Omniax\basement_chatBot\Data\PrivateMessageData> $privateMessages
     */
    protected function notify(Authenticatable $receiver, Collection $privateMessages): void
    {
        $privateMessages
            ->groupBy('sender_id')
            ->tap(function (Collection $groupedMessages) use ($receiver): void {
                broadcast(new PrivateMessagesReceivedMarkedAsRead(
                    receiverId: (int) $receiver->id,
                    messages: $groupedMessages,
                ));
            })
            ->each(static fn (Collection $messages, int $senderId) => broadcast(new PrivateMessagesSentMarkedAsRead(
                receiverId: (int) $receiver->id,
                senderId: (int) $senderId,
                messages: $messages,
            )));
    }
}
