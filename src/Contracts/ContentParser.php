<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Contracts;

interface ContentParser
{
    public function parse(array|string|null $content): array|string|null;
}
