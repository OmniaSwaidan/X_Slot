<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Contracts;

use Omniax\basement_chatBot\Data\PrivateMessageData;

interface SendPrivateMessage
{
    /**
     * Send a private message to the receiver.
     */
    public function send(PrivateMessageData $privateMessage): PrivateMessageData;
}
