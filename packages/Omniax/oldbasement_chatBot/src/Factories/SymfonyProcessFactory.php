<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Factories;

use Symfony\Component\Process\Process;

class SymfonyProcessFactory
{
    /**
     * Create a new Symfony Process instance.
     *
     * @param array<int,string> $command
     */
    public function create(array $command): Process
    {
        return new Process($command);
    }
}
