<?php

declare(strict_types=1);

use Omniax\basement_chatBot\Http\Controllers\Api\ContactController;
use Omniax\basement_chatBot\Http\Controllers\Api\CurrentlyTypingController;
use Omniax\basement_chatBot\Http\Controllers\Api\PrivateMessageController;
use Omniax\basement_chatBot\Http\Controllers\Api\ChatBotController;
use Illuminate\Support\Facades\Route;

/** @var array $middleware */
$middleware = config('basement.middleware', [
    \Laravel\Sanctum\Http\Middleware\EnsureFrontendRequestsAreStateful::class,
    'throttle:api',
    \Illuminate\Routing\Middleware\SubstituteBindings::class,
    'auth:sanctum',
]);

Route::middleware($middleware)->name('api.basement.')->prefix('api/basement')->group(static function (): void {
    Route::apiResource(name: 'contacts', controller: ContactController::class)
        ->only('index');

    Route::apiResource(name: 'contacts.private-messages', controller: PrivateMessageController::class)
        ->shallow()
        ->only(['index', 'store']);

    Route::get(uri: 'contacts/{contact}/currently-typing', action: CurrentlyTypingController::class)
        ->name('contacts.currently-typing');

    Route::patch(uri: 'private-messages', action: [PrivateMessageController::class, 'updates'])
        ->name('private-messages.updates');

        Route::post('/chat/send-message', [ChatBotController::class, 'sendMessage']);
});
