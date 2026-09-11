<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Contracts;

interface Sanitizer
{
    /**
     * @param  array<string,mixed>|string|null  $content
     * @return array<string,mixed>|string|null
     */
    public function sanitize(array|string|null $content): array|string|null;
}
