<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Http\Controllers\Api;

use Omniax\basement_chatBot\Contracts\AllPrivateMessages;
use Omniax\basement_chatBot\Contracts\MarkPrivatesMessagesAsRead;
use Omniax\basement_chatBot\Contracts\SendPrivateMessage;
use Omniax\basement_chatBot\Data\PrivateMessageData;
use Omniax\basement_chatBot\Enums\MessageType;
use Omniax\basement_chatBot\Http\Requests\StorePrivateMessageRequest;
use Omniax\basement_chatBot\Http\Requests\UpdatePrivateMessagesRequest;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class PrivateMessageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @param  \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User  $contact
     */
    public function index(
        Request $request,
        Authenticatable $contact,
        AllPrivateMessages $allPrivateMessages,
    ): JsonResponse {
        /** @var \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $user */
        $user = Auth::user();

        /** @var string $keyword */
        $keyword = $request->get('keyword') ?? '';

        $messages = $allPrivateMessages->allBetweenTwoUsers(receiver: $user, sender: $contact, keyword: $keyword);

        return JsonResource::collection($messages)->response();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User  $contact
     */
    public function store(
        Authenticatable $contact,
        StorePrivateMessageRequest $request,
        SendPrivateMessage $sendPrivateMessage
    ): JsonResponse {
        /** @var int $senderId */
        $senderId = Auth::id();

        /** @var string $value */
        $value = $request->input('value');

        $message = $sendPrivateMessage->send(new PrivateMessageData(
            receiver_id: (int) $contact->id,
            sender_id: (int) $senderId,
            type: MessageType::text(),
            value: $value,
        ));

        return (new JsonResource($message))->response()->setStatusCode(Response::HTTP_CREATED);
    }

    /**
     * Update specified resources in storage.
     */
    public function updates(
        UpdatePrivateMessagesRequest $request,
        MarkPrivatesMessagesAsRead $markPrivatesMessagesAsRead,
    ): JsonResponse {
        /** @var \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $user */
        $user = Auth::user();

        $messages = $markPrivatesMessagesAsRead->markAsRead(
            readBy: $user,
            privateMessages: $request->markAsReadOperation(),
        );

        return JsonResource::collection($messages->values())->response();
    }
}
