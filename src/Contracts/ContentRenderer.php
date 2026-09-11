<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Contracts;

interface ContentRenderer
{
    /**
     * @param  array<string,mixed>|string|null  $content
     * @param  array<string,mixed>  $context
     */
    public function render(array|string|null $content, array $context = []): string;
}
