<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Commands;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<int, array<string, mixed>>
 */
class CommandChain implements Arrayable
{
    /** @var array<int, Command> */
    private array $commands = [];

    public function push(Command $command): self
    {
        $this->commands[] = $command;

        return $this;
    }

    /** @param array<string,mixed> $payload */
    public function command(string $name, array $payload = []): self
    {
        return $this->push(new Command($name, $payload));
    }

    /** @return array<int,array<string,mixed>> */
    public function run(): array
    {
        return $this->toArray();
    }

    /** @return array<int,array<string,mixed>> */
    public function toArray(): array
    {
        return array_map(static fn (Command $command): array => $command->toArray(), $this->commands);
    }
}
