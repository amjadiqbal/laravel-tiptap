<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Support;

use AmjadIqbal\LaravelTiptap\Contracts\ContentTransformer;

class DefaultContentTransformer implements ContentTransformer
{
    public function transform(array|string|null $content, string $targetFormat, array $context = []): mixed
    {
        if ($targetFormat === 'json') {
            if (is_array($content)) {
                return $content;
            }

            if (is_string($content) && $content !== '') {
                return json_decode($content, true);
            }

            return null;
        }

        if ($targetFormat === 'html') {
            if (is_string($content)) {
                return $content;
            }

            return (string) json_encode($content, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return $content;
    }
}
