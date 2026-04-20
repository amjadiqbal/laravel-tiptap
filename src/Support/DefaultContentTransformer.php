<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Support;

use AmjadIqbal\LaravelTiptap\Contracts\ContentTransformer;

class DefaultContentTransformer implements ContentTransformer
{
    public function transform(array|string|null $content, string $targetFormat, array $context = []): mixed
    {
        return match ($targetFormat) {
            'json' => is_array($content) ? $content : (is_string($content) && $content !== '' ? json_decode($content, true) : null),
            'html' => is_string($content) ? $content : (string) json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES),
            default => $content,
        };
    }
}
