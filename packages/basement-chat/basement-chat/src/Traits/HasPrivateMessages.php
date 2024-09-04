<?php

declare(strict_types=1);

namespace BasementChat\Basement\Traits;

use BasementChat\Basement\Contracts\User;
use BasementChat\Basement\Facades\Basement;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Query\Builder as QueryBuilder;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Facades\DB;

/**
 * @method static Authenticatable&User&static addSelectLastPrivateMessageId(Authenticatable&User $value)
 * @method static Authenticatable&User&static addSelectUnreadMessages(Authenticatable&User $value)
 */
trait HasPrivateMessages
{
    /**
     * Get the user's avatar.
     */
    public function getAvatarAttribute(): string
    {
        $style = Basement::getAvatarStyle();
        $options = Basement::getAvatarOptions();
        $hash = md5($this->getNameAttribute());

        $queryString = collect($options)
            ->map(static fn (string $option, string $key): string => ("{$key}={$option}"))
            ->join('&');

        return "https://avatars.dicebear.com/api/{$style->value}/{$hash}.svg?{$queryString}";
    }

    /**
     * Get the user's name.
     */
    public function getNameAttribute(): string
    {
        return $this->attributes['name'] ?? '';
    }

    /**
     * Get all private messages that the user receives.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\BasementChat\Basement\Models\PrivateMessage>
     */
    public function privateMessagesReceived(): HasMany
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */

        return $this->hasMany(related: Basement::privateMessageModel(), foreignKey: 'receiver_id');
    }

    /**
     * Get all private messages sent by the user.
     *
     * @return \Illuminate\Database\Eloquent\Relations\HasMany<\BasementChat\Basement\Models\PrivateMessage>
     */
    public function privateMessagesSent(): HasMany
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */

        return $this->hasMany(related: Basement::privateMessageModel(), foreignKey: 'sender_id');
    }

    /**
     * Get the private message that owns the last private message id.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo<Model,\BasementChat\Basement\Models\PrivateMessage>
     */
    public function lastPrivateMessage(): BelongsTo
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */

        return $this->belongsTo(related: Basement::privateMessageModel(), foreignKey: 'last_private_message_id');
    }

    /**
     * Scope a query to append the latest private message id.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<Authenticatable>|\Illuminate\Database\Query\Builder  $query
     * @param  \Illuminate\Foundation\Auth\User&\BasementChat\Basement\Contracts\User $user
     */
    public function scopeAddSelectLastPrivateMessageId(Builder|QueryBuilder $query, Authenticatable $user): void
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */

        $query->addSelect([
            'last_private_message_id' => Basement::newPrivateMessageModel()
                ->orderByDescId()
                ->select('id')
                ->where(fn (Builder|QueryBuilder $clause): Builder => $clause
                    ->where('receiver_id', $user->id)
                    ->whereColumn('sender_id', "{$this->getTable()}.{$this->primaryKey}"))
                ->orWhere(fn (Builder|QueryBuilder $clause): Builder => $clause
                    ->where('sender_id', $user->id)
                    ->whereColumn('receiver_id', "{$this->getTable()}.{$this->primaryKey}"))
                ->limit(1),
        ]);
    }

    /**
     * Scope a query to append the number of unread messages.
     *
     * @param  \Illuminate\Database\Eloquent\Builder<Authenticatable>|\Illuminate\Database\Query\Builder  $query
     * @param  \Illuminate\Foundation\Auth\User&\BasementChat\Basement\Contracts\User $user
     */
    public function scopeAddSelectUnreadMessages(Builder|QueryBuilder $query, Authenticatable $user): void
    {
        /** @var \Illuminate\Database\Eloquent\Model $this */

        $query->addSelect([
            'unread_messages' => Basement::newPrivateMessageModel()
                ->select([
                    DB::raw(<<<'SQL'
                        COUNT(*)
                    SQL),
                ])
                ->where(fn (Builder|QueryBuilder $clause): Builder => $clause
                    ->where('receiver_id', $user->id)
                    ->whereColumn('sender_id', "{$this->getTable()}.{$this->primaryKey}"))
                ->whereNull('read_at'),
        ]);
    }
}
