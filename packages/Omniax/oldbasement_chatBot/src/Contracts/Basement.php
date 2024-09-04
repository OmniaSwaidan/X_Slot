<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Contracts;

use Omniax\basement_chatBot\Enums\AvatarStyle;
use Omniax\basement_chatBot\Enums\ChatBoxPosition;
use Omniax\basement_chatBot\Models\PrivateMessage;
use Illuminate\Foundation\Auth\User as Authenticatable;

interface Basement
{
    /**
     * Specify the user model used by the application.
     */
    public static function useUserModel(mixed $class): void;

    /**
     * Get the name of the user model used by the application.
     *
     * @return class-string<\Illuminate\Foundation\Auth\User>&class-string<\Omniax\basement_chatBot\Contracts\User>
     *
     * @throws \TypeError if the given user model is not a subclass of \Illuminate\Foundation\Auth\User
     *                    or does not implement the \Omniax\basement_chatBot\Contracts\User.
     */
    public static function userModel(): string;

    /**
     * Get a new instance of the user model.
     *
     * @return \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User
     */
    public static function newUserModel(): Authenticatable;

    /**
     * Specify the private message model used by the application.
     */
    public static function usePrivateMessageModel(mixed $class): void;

    /**
     * Get the name of the private message model used by the application.
     *
     * @return class-string<\Omniax\basement_chatBot\Models\PrivateMessage>
     *
     * @throws \TypeError if the given user model is not a subclass of \Omniax\basement_chatBot\Models\PrivateMessage.
     */
    public static function privateMessageModel(): string;

    /**
     * Get a new instance of the private message model.
     */
    public static function newPrivateMessageModel(): PrivateMessage;

    /**
     * Register a class / callback that should be used to get all contacts.
     *
     * @param  class-string<\Omniax\basement_chatBot\Contracts\AllContacts>   $class
     */
    public static function allContactsUsing(string $class): void;

    /**
     * Register a class / callback that should be used to get mark private messages as read.
     *
     * @param  class-string<\Omniax\basement_chatBot\Contracts\MarkPrivatesMessagesAsRead>   $class
     */
    public static function markPrivateMessagesAsReadUsing(string $class): void;

    /**
     * Get the avatar style from the basement configuration file.
     */
    public static function getAvatarStyle(): AvatarStyle;

    /**
     * Get the avatar options from the basement configuration file.
     *
     * @return array<string,string|int|bool>
     */
    public static function getAvatarOptions(): array;

    /**
     * Get the chat box widget position from the basement configuration file.
     */
    public static function getChatBoxWidgetPosition(): ChatBoxPosition;

    /**
     * Get the Laravel Echo client-side broadcast options from the basement configuration file.
     *
     * @return array<string,string|int|bool>
     */
    public static function getBroadcastOptions(): array;
}
