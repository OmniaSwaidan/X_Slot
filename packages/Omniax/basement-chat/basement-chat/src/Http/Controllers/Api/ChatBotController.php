<?php
declare(strict_types=1);

namespace BasementChat\Basement\Http\Controllers\Api;
use Illuminate\Routing\Controller;

use BotMan\BotMan\BotMan;
use Illuminate\Http\Request;

class ChatBotController extends Controller
{
    public function index()
    {
        $botman = app(BotMan::class);

        $botman->hears('hello', function (BotMan $bot) {
            $bot->reply('Hello! How can I help you?');
        });

        $botman->hears('goodbye', function (BotMan $bot) {
            $bot->reply('See you later!');
        });

        $botman->fallback(function (BotMan $bot) {
            $bot->reply('I didn\'t understand that.');
        });

        $botman->listen();
    }
}
