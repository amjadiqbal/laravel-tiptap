<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Support;

use AmjadIqbal\LaravelTiptap\Contracts\ContentRenderer;

class DefaultContentRenderer implements ContentRenderer
{
    /** @param array<string,mixed>|string|null $content
     * @param array<string,mixed> $context */
    public function render(array|string|null $content, array $context = []): string
    {
        if (is_string($content)) {
            return $content;
        }

        if (is_array($content)) {
            return (string) json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES | JSON_PRETTY_PRINT);
        }

        return '';
    }
}
