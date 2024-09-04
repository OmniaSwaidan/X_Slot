<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Actions;

use Omniax\basement_chatBot\Contracts\AllPrivateMessages as AllPrivateMessagesContract;
use Omniax\basement_chatBot\Facades\Basement;
use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Foundation\Auth\User as Authenticatable;

class AllPrivateMessages implements AllPrivateMessagesContract
{
    /**
     * The total number of messages displayed per page.
     */
    protected const MESSAGES_PER_PAGE = 50;

    /**
     * Get all private messages between to a given user list.
     *
     * @param \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $receiver
     * @param \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $sender
     *
     * @return \Illuminate\Contracts\Pagination\CursorPaginator<\Omniax\basement_chatBot\Models\PrivateMessage>
     */
    public function allBetweenTwoUsers(
        Authenticatable $receiver,
        Authenticatable $sender,
        string $keyword = '',
    ): CursorPaginator {
        return Basement::newPrivateMessageModel()
            ->whereBetweenTwoUsers($receiver, $sender)
            ->whereValueLike($keyword)
            ->orderByDescId()
            ->cursorPaginate(self::MESSAGES_PER_PAGE);
    }
}
