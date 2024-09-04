<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Casts;

use Omniax\basement_chatBot\Enums\MessageType;
use Illuminate\Contracts\Database\Eloquent\CastsAttributes;

/**
 * @implements CastsAttributes<MessageType,MessageType>
 */
class AsMessageType implements CastsAttributes
{
    /**
     * Transform the attribute from the underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  string|int  $value
     * @param  array<model-property<\Omniax\basement_chatBot\Models\PrivateMessage>,mixed>  $attributes
     */
    public function get(mixed $model, string $key, mixed $value, array $attributes): MessageType
    {
        return MessageType::from($value);
    }

    /**
     * Transform the attribute to its underlying model values.
     *
     * @param  \Illuminate\Database\Eloquent\Model  $model
     * @param  \Omniax\basement_chatBot\Enums\MessageType  $value
     * @param  array<model-property<\Omniax\basement_chatBot\Models\PrivateMessage>,mixed>  $attributes
     */
    public function set(mixed $model, string $key, mixed $value, array $attributes): string
    {
        return (string) $value->value;
    }
}
