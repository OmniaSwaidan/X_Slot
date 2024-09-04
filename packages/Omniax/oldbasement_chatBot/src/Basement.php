<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot;

use Omniax\basement_chatBot\Contracts\AllContacts;
use Omniax\basement_chatBot\Contracts\AllPrivateMessages;
use Omniax\basement_chatBot\Contracts\Basement as BasementContract;
use Omniax\basement_chatBot\Contracts\MarkPrivatesMessagesAsRead;
use Omniax\basement_chatBot\Contracts\SendPrivateMessage;
use Omniax\basement_chatBot\Contracts\User as UserContract;
use Omniax\basement_chatBot\Enums\AvatarStyle;
use Omniax\basement_chatBot\Enums\ChatBoxPosition;
use Omniax\basement_chatBot\Models\PrivateMessage;
use Illuminate\Foundation\Auth\User as Authenticatable;

class Basement implements BasementContract
{
    /**
     * The user model used by the application.
     */
    protected static mixed $userModel;

    /**
     * The private message model used by the application.
     */
    protected static mixed $privateMessageModel;

    /**
     * Specify the user model used by the application.
     */
    public static function useUserModel(mixed $class): void
    {
        static::$userModel = $class;
    }

    /**
     * Get the name of the user model used by the application.
     *
     * @return class-string<\Illuminate\Foundation\Auth\User>&class-string<\Omniax\basement_chatBot\Contracts\User>
     *
     * @throws \TypeError if the given user model is not a subclass of \Illuminate\Foundation\Auth\User
     *                    or does not implement the \Omniax\basement_chatBot\Contracts\User.
     */
    public static function userModel(): string
    {
        if (
            is_string(static::$userModel) === false
            || class_exists(static::$userModel) === false
            || is_subclass_of(static::$userModel, Authenticatable::class) === false
            || is_subclass_of(static::$userModel, UserContract::class) === false
        ) {
            throw new \TypeError(
                'The given configuration user_model should be a subclass of ' . Authenticatable::class .
                ' class and implement the ' . UserContract::class . ' interface.',
            );
        }

        return static::$userModel;
    }

    /**
     * Get a new instance of the user model.
     *
     * @return \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User
     */
    public static function newUserModel(): Authenticatable
    {
        return app(static::userModel());
    }

    /**
     * Specify the private message model used by the application.
     */
    public static function usePrivateMessageModel(mixed $class): void
    {
        static::$privateMessageModel = $class;
    }

    /**
     * Get the name of the private message model used by the application.
     *
     * @return class-string<\Omniax\basement_chatBot\Models\PrivateMessage>
     *
     * @throws \TypeError if the given user model is not a subclass of \Omniax\basement_chatBot\Models\PrivateMessage.
     */
    public static function privateMessageModel(): string
    {
        if (
            is_string(static::$privateMessageModel) === false
            || class_exists(static::$privateMessageModel) === false
            || (is_subclass_of(static::$privateMessageModel, PrivateMessage::class) === false
                && static::$privateMessageModel !== PrivateMessage::class)
        ) {
            throw new \TypeError(
                'The given private message model should be a subclass of ' . PrivateMessage::class . ' class.',
            );
        }

        return static::$privateMessageModel;
    }

    /**
     * Get a new instance of the private message model.
     */
    public static function newPrivateMessageModel(): PrivateMessage
    {
        return app(static::privateMessageModel());
    }

    /**
     * Register a class / callback that should be used to get all contacts.
     *
     * @param  class-string<\Omniax\basement_chatBot\Contracts\AllContacts>   $class
     */
    public static function allContactsUsing(string $class): void
    {
        app()->bind(abstract: AllContacts::class, concrete: $class);
    }

    /**
     * Register a class / callback that should be used to get all private messages.
     *
     * @param  class-string<\Omniax\basement_chatBot\Contracts\AllPrivateMessages>   $class
     */
    public static function allPrivateMessagesUsing(string $class): void
    {
        app()->bind(abstract: AllPrivateMessages::class, concrete: $class);
    }

    /**
     * Register a class / callback that should be used to get mark private messages as read.
     *
     * @param  class-string<\Omniax\basement_chatBot\Contracts\MarkPrivatesMessagesAsRead>   $class
     */
    public static function markPrivateMessagesAsReadUsing(string $class): void
    {
        app()->bind(abstract: MarkPrivatesMessagesAsRead::class, concrete: $class);
    }

    /**
     * Register a class / callback that should be used to send a private message.
     *
     * @param  class-string<\Omniax\basement_chatBot\Contracts\SendPrivateMessage>   $class
     */
    public static function sendPrivateMessagesUsing(string $class): void
    {
        app()->bind(abstract: SendPrivateMessage::class, concrete: $class);
    }

    /**
     * Get the avatar style from the basement configuration file.
     */
    public static function getAvatarStyle(): AvatarStyle
    {
        $style = AvatarStyle::tryFrom(config('basement.avatar.style'));

        if ($style instanceof AvatarStyle === false) {
            throw new \TypeError(
                'The given configuration basement.avatar.style should be instanceof '
                . AvatarStyle::class . ' class.',
            );
        }

        return $style;
    }

    /**
     * Get the avatar options from the basement configuration file.
     *
     * @return array<string,int|bool|string|null>
     */
    public static function getAvatarOptions(): array
    {
        /** @var mixed $options */
        $options = config('basement.avatar.options');

        if (is_array($options) === false) {
            throw new \TypeError(
                'The given configuration avatar.options inside config/basement.php should be of type array',
            );
        }

        return $options;
    }

    /**
     * Get the chat box widget position from the basement configuration file.
     */
    public static function getChatBoxWidgetPosition(): ChatBoxPosition
    {
        $position = ChatBoxPosition::tryFrom(config('basement.chat_box_widget_position'));

        if ($position instanceof ChatBoxPosition === false) {
            throw new \TypeError(
                'The given configuration chat_box_widget_position inside config/basement.php should be instanceof '
                . ChatBoxPosition::class . ' class.',
            );
        }

        return $position;
    }

    /**
     * Get the Laravel Echo client-side broadcast options from the basement configuration file.
     *
     * @return array<string,string|int|bool>
     */
    public static function getBroadcastOptions(): array
    {
        /** @var mixed $connections */
        $connections = config('basement.broadcaster.connections');
        $driver = config('basement.broadcaster.default');

        if (
            is_array($connections) === false
            || is_string($driver) === false
            || array_key_exists($driver, $connections) === false
        ) {
            throw new \TypeError(
                'The given configuration broadcaster.default inside config/basement.php should be available as an array key inside basement.broadcaster.connections.',
            );
        }

        return $connections[$driver];
    }
}
