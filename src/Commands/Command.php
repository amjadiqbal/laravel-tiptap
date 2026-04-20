<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Commands;

use Illuminate\Contracts\Support\Arrayable;

class Command implements Arrayable
{
    /** @param array<string,mixed> $payload */
    public function __construct(public readonly string $name, public readonly array $payload = [])
    {
    }

    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'payload' => $this->payload,
        ];
    }
}
