<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Contracts;

interface ContentParser
{
    /**
     * @param  array<string,mixed>|string|null  $content
     * @return array<string,mixed>|string|null
     */
    public function parse(array|string|null $content): array|string|null;
}
