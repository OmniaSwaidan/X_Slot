<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Contracts;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Collection;

interface AllContacts
{
    /**
     * Get all contact list.
     *
     * @param \Illuminate\Foundation\Auth\User&\Omniax\basement_chatBot\Contracts\User $user
     *
     * @return \Illuminate\Support\Collection<int,\Omniax\basement_chatBot\Data\ContactData>
     */
    public function all(Authenticatable $user): Collection;
}
