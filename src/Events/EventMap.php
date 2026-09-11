<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Events;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, string|null>
 */
class EventMap implements Arrayable
{
    /** @var array<string,string|null> */
    private array $events = [];

    public function set(string $event, ?string $handler = null): self
    {
        $this->events[$event] = $handler;

        return $this;
    }

    /** @return array<string,string|null> */
    public function toArray(): array
    {
        return $this->events;
    }
}
