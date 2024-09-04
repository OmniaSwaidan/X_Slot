<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Facades;

use Omniax\basement_chatBot\Contracts\Basement as BasementContract;
use Illuminate\Support\Facades\Facade;

/**
 * @mixin \Omniax\basement_chatBot\Basement
 */
class Basement extends Facade
{
    /**
     * Get the registered name of the component.
     */
    protected static function getFacadeAccessor(): string
    {
        return BasementContract::class;
    }
}
