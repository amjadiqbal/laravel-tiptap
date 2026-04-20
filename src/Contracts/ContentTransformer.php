<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Contracts;

interface ContentTransformer
{
    /** @param array<string,mixed> $context */
    public function transform(array|string|null $content, string $targetFormat, array $context = []): mixed;
}
