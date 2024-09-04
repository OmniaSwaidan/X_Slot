<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Broadcasting;

use Omniax\basement_chatBot\Data\ContactData;
use Omniax\basement_chatBot\Facades\Basement;
use Illuminate\Foundation\Auth\User as Authenticatable;

class ContactsChannel
{
    /**
     * Authenticate the user's access to the channel.
     *
     * @param  \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $user
     *
     * @return array<string,mixed>
     */
    public function join(Authenticatable $user): array
    {
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
