<?php

declare(strict_types=1);

use Omniax\basement_chatBot\Broadcasting\ContactChannel;
use Omniax\basement_chatBot\Broadcasting\ContactsChannel;
use Illuminate\Support\Facades\Broadcast;

Broadcast::channel(channel: 'basement.contacts', callback: ContactsChannel::class);
Broadcast::channel(channel: 'basement.contacts.{id}', callback: ContactChannel::class);
