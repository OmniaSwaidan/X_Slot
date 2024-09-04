<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Http\Controllers\Api;

use Omniax\basement_chatBot\Events\CurrentlyTyping;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\Response;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;

class CurrentlyTypingController extends Controller
{
    /**
     * Broadcast the currently typing event to the receiver.
     *
     * @param  \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User  $contact
     */
    public function __invoke(
        Authenticatable $contact,
    ): Response {
        /** @var int $senderId */
        $senderId = Auth::id();

        broadcast(new CurrentlyTyping(
            senderId: $senderId,
            receiverId: $contact->id,
        ));

        return response()->noContent();
    }
}
