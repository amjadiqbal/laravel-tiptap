<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Tests\Unit;

use AmjadIqbal\LaravelTiptap\Support\HtmlSanitizer;
use PHPUnit\Framework\TestCase;

class SanitizerTest extends TestCase
{
    public function test_it_removes_disallowed_tags(): void
    {
        $sanitizer = new HtmlSanitizer(['p', 'strong']);

        $sanitized = $sanitizer->sanitize('<p>Hello <script>alert(1)</script><strong>World</strong></p>');

        $this->assertSame('<p>Hello alert(1)<strong>World</strong></p>', $sanitized);
    }
}
