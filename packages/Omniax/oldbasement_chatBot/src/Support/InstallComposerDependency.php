<?php

declare(strict_types=1);

namespace Omniax\basement_chatBot\Support;

use Omniax\basement_chatBot\Factories\SymfonyProcessFactory;
use Illuminate\Console\Command;

class InstallComposerDependency
{
    /**
     * Create a new pipe class instance.
     */
    public function __construct(
        protected SymfonyProcessFactory $process,
    ) {
    }

    /**
     * Install composer dependencies.
     *
     * @param array<int,string> $dependencies
     */
    public function install(Command $command, array $dependencies, bool $dev = false): int
    {
        return $this->process
            ->create(array_merge([
                'composer',
                'require',
                ...$dependencies,
            ], $dev === true ? ['--dev'] : []))
            ->setTimeout(null)
            ->run(static fn (string $type, string $data) => $command->getOutput()->write($data));
    }
}
