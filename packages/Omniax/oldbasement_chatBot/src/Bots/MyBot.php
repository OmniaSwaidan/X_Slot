<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Bots;

use Omniax\basement_chatBot\Contracts\Basement as BasementContract;
use Omniax\basement_chatBot\Services\BotService;

class MyBot
{
    private $bot_service;
    public function __construct(BotService $bot_service)
    {
        $this->bot_service = $bot_service;
    }
    // Implement the methods defined in the BasementContract interface
    public function sendResponse($response)
    {
        $response = $this->bot_service->getResponse($response);
    }
}
