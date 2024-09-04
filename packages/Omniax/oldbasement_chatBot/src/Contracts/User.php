<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Contracts;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @phpstan-method static Authenticatable&User addSelectLastPrivateMessageId(Authenticatable&User $value)
 * @phpstan-method static Authenticatable&User addSelectUnreadMessages(Authenticatable&User $value)
 *
 * @property string $name
 * @property string $avatar
 * @property int|null $unread_messages
 * @property \Omniax\basement_chatBot\Models\PrivateMessage|null $lastPrivateMessage
 */
interface User
{
    /**
     * Get the user's avatar.
     */
    public function getAvatarAttribute(): string;

    /**
     * Get the user's name.
     */
    public function getNameAttribute(): string;

    /**
     * Get all private messages that the user receives.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Omniax\basement_chatBot\Models\PrivateMessage>
     */
    public function privateMessagesReceived(): HasMany;

    /**
     * Get all private messages sent by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\Omniax\basement_chatBot\Models\PrivateMessage>
     */
    public function privateMessagesSent(): HasMany;

    /**
     * Get the private message that owns the last private message id.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Model,\Omniax\basement_chatBot\Models\PrivateMessage>
     */
    public function lastPrivateMessage(): BelongsTo;

    /**
     * Scope a query to append the latest private message id.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<Authenticatable>|\Illuminate\Database\Query\Builder  $query
     * @param  \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $user
     */
    public function scopeAddSelectLastPrivateMessageId(Builder|QueryBuilder $query, Authenticatable $user): void;

    /**
     * Scope a query to append the number of unread messages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<Authenticatable>|\Illuminate\Database\Query\Builder  $query
     * @param  \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $user
     */
    public function scopeAddSelectUnreadMessages(Builder|QueryBuilder $query, Authenticatable $user): void;
}
