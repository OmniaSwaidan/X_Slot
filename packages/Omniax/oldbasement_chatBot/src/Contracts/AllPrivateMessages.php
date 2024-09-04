<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Contracts;

use Illuminate\Contracts\Pagination\CursorPaginator;
use Illuminate\Foundation\Auth\User as Authenticatable;

interface AllPrivateMessages
{
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
    ): CursorPaginator;
}
