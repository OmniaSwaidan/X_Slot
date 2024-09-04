<?php

namespace Omniax\basement_chatBot\Services;

use GuzzleHttp\Client;

class BotService
{
    protected $client;

    public function __construct()
    {
        $this->client = new Client();
    }

    public function getResponse(string $message): string
    {
        // Example: Sending message to a Dialogflow bot
        $response = $this->client->post('https://api.dialogflow.com/v1/query?v=20150910', [
            'headers' => [
                'Authorization' => 'Bearer YOUR_DIALOGFLOW_ACCESS_TOKEN',
                'Content-Type' => 'application/json',
            ],
            'json' => [
                'query' => $message,
                'lang' => 'en',
                'sessionId' => uniqid(),
            ],
        ]);

        $body = json_decode($response->getBody(), true);
        return $body['result']['fulfillment']['speech'];
    }
}
