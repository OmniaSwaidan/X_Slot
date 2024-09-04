<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Broadcasting;

use Omniax\basement_chatBot\Data\ContactData;
use Omniax\basement_chatBot\Facades\Basement;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ContactChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $user
     *
     * @return array<string,mixed>|null
     */
    public function join(Authenticatable $user, int $id): ?array
    {
        if ($user->id !== $id) {
            return null;
        }

        /** @var \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $contact */
        $contact = Basement::newUserModel()->findOrFail($user->id);
        $contact->append('avatar');

        return (new ContactData(
            id: (int) $contact->id,
            name: $contact->name,
            avatar: $contact->avatar,
            last_private_message: null,
        ))->toArray();
    }
}
