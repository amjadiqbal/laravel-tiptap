<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Support;

use AmjadIqbal\LaravelTiptap\Contracts\ContentParser;
use AmjadIqbal\LaravelTiptap\Exceptions\InvalidContentException;

class DefaultContentParser implements ContentParser
{
    /**
     * @param  array<string,mixed>|string|null  $content
     * @return array<string,mixed>|string|null
     */
    public function parse(array|string|null $content): array|string|null
    {
        if (! is_string($content)) {
            return $content;
        }

        $decoded = json_decode($content, true);

        if (json_last_error() === JSON_ERROR_NONE && is_array($decoded)) {
            return $decoded;
        }

        if (trim($content) === '') {
            return null;
        }

        if (str_starts_with(trim($content), '{') || str_starts_with(trim($content), '[')) {
            throw InvalidContentException::because('JSON content could not be parsed.');
        }

        return $content;
    }
}
