<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Commands;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class Command implements Arrayable
{
    /** @param array<string,mixed> $payload */
    public function __construct(public readonly string $name, public readonly array $payload = []) {}

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'payload' => $this->payload,
        ];
    }
}
