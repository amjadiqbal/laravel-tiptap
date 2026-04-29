<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Support;

use AmjadIqbal\LaravelTiptap\Contracts\Sanitizer;

class HtmlSanitizer implements Sanitizer
{
    /** @param array<int,string> $allowedTags */
    public function __construct(private readonly array $allowedTags = [])
    {
    }

    public function sanitize(array|string|null $content): array|string|null
    {
        if (is_array($content)) {
            return $content;
        }

        if (! is_string($content)) {
            return $content;
        }

        if ($this->allowedTags === []) {
            return strip_tags($content);
        }

        $tagString = implode('', array_map(static fn (string $tag): string => "<{$tag}>", $this->allowedTags));

        return strip_tags($content, $tagString);
    }
}
