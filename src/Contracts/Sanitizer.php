<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Contracts;

interface Sanitizer
{
    public function sanitize(array|string|null $content): array|string|null;
}
