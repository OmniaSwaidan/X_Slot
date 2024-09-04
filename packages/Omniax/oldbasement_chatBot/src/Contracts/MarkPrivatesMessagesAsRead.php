<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Contracts;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

interface MarkPrivatesMessagesAsRead
{
    /**
     * Mark given private messages as has been read.
     *
     * @param \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $readBy
     * @param \Illuminate\Support\Collection<int,\Omniax\basement_chatBot\Data\PrivateMessageData> $privateMessages
     *
     * @return \Illuminate\Support\Collection<int,\Omniax\basement_chatBot\Data\PrivateMessageData>
     */
    public function markAsRead(Authenticatable $readBy, Collection $privateMessages): Collection;
}
