<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Exceptions;

use InvalidArgumentException;

class InvalidExtensionException extends InvalidArgumentException
{
    public static function because(string $reason): self
    {
        return new self($reason);
    }
}
