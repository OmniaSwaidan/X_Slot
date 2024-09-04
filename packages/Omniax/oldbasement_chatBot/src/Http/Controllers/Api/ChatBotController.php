<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Http\Controllers\Api;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Omniax\basement_chatBot\Services\BotService;
use Illuminate\Routing\Controller;

class ChatBotController extends Controller
{
    protected $botService;

    public function __construct(BotService $botService)
    {
        $this->botService = $botService;
    }

    public function sendMessage(Request $request): JsonResponse
    {
        $userMessage = $request->input('message');

        // If message is intended for the bot, get bot response
        $botResponse = $this->botService->getResponse($userMessage);

        // Here, you would normally save the bot response and user message to the chat history

        return response()->json(['message' => $botResponse]);
    }
}
