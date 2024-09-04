<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Database\Factories;

use Omniax\basement_chatBot\Enums\MessageType;
use Omniax\basement_chatBot\Models\PrivateMessage;
use Omniax\basement_chatBot\Tests\Fixtures\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Foundation\Auth\User as Authenticatable;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\Omniax\basement_chatBot\Models\PrivateMessage>
 */
class PrivateMessageFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var class-string<\Omniax\basement_chatBot\Models\PrivateMessage>
     */
    protected $model = PrivateMessage::class;

    /**
     * Define the model's default state.
     *
     * @return array<model-property<\Omniax\basement_chatBot\Models\PrivateMessage>,mixed>
     */
    public function definition(): array
    {
        /** @var \Omniax\basement_chatBot\Tests\Fixtures\Models\User $receiver */
        $receiver = User::inRandomOrder()->first();

        /** @var \Omniax\basement_chatBot\Tests\Fixtures\Models\User $sender */
        $sender = User::inRandomOrder()->first();

        return [
            'receiver_id' => $receiver->id,
            'sender_id' => $sender->id,
            'type' => MessageType::text(),
            'value' => fake()->text(50),
            'read_at' => null,
        ];
    }

    /**
     * Indicate that the receiver and sender model's should be two given users.
     *
     * @param \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $receiver
     * @param \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $sender
     */
    public function betweenTwoUsers(Authenticatable $receiver, Authenticatable $sender): self
    {
        return $this->state([
            'receiver_id' => $receiver->id,
            'sender_id' => $sender->id,
        ]);
    }

    /**
     * Indicate that the receiver and sender model's should be same.
     *
     * @param \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $user
     */
    public function sendToSelf(Authenticatable $user): self
    {
        return $this->state([
            'receiver_id' => $user->id,
            'sender_id' => $user->id,
        ]);
    }
}
