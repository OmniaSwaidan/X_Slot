<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Actions;

use Omniax\basement_chatBot\Contracts\AllContacts as AllContactsContract;
use Omniax\basement_chatBot\Data\ContactData;
use Omniax\basement_chatBot\Data\PrivateMessageData;
use Omniax\basement_chatBot\Facades\Basement;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

class AllContacts implements AllContactsContract
{
    /**
     * Get all contact list.
     *
     * @param \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $user
     *
     * @return \Illuminate\Support\Collection<int,\Omniax\basement_chatBot\Data\ContactData>
     */
    public function all(Authenticatable $user): Collection
    {
        /** @var \Illuminate\Database\Eloquent\Collection<int,Authenticatable&\Omniax\basement_chatBot\Contracts\User> $contacts */
        $contacts = Basement::newUserModel()
            ->addSelectLastPrivateMessageId($user)
            ->addSelectUnreadMessages($user)
            ->get();

        $contacts->append('avatar');
        $contacts->load('lastPrivateMessage');

        return $contacts
            ->sortByDesc('lastPrivateMessage.id')
            ->values()
            ->map(fn (Authenticatable $contact): ContactData => $this->convertToContactData($contact));
    }

    /**
     * @param \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $contact
     */
    protected function convertToContactData(Authenticatable $contact): ContactData
    {
        return new ContactData(
            id: (int) $contact->id,
            name: $contact->name,
            avatar: $contact->avatar,
            last_private_message: (static fn () => $contact->lastPrivateMessage !== null ? new PrivateMessageData(
                receiver_id: (int) $contact->lastPrivateMessage->receiver_id,
                sender_id: (int) $contact->lastPrivateMessage->sender_id,
                type: $contact->lastPrivateMessage->type,
                value: $contact->lastPrivateMessage->value,
                id: (int) $contact->lastPrivateMessage->id,
                created_at: $contact->lastPrivateMessage->created_at,
                read_at: $contact->lastPrivateMessage->read_at,
            ) : null)(),
            unread_messages: (int) $contact->unread_messages,
        );
    }
}
