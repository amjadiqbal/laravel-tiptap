<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Tests\Unit;

use AmjadIqbal\LaravelTiptap\Exceptions\InvalidContentException;
use AmjadIqbal\LaravelTiptap\Support\DefaultContentParser;
use PHPUnit\Framework\TestCase;

class ContentParserTest extends TestCase
{
    public function test_it_parses_json_content_into_array(): void
    {
        $parser = new DefaultContentParser;

        $parsed = $parser->parse('{"type":"doc","content":[]}');

        $this->assertIsArray($parsed);
        $this->assertSame('doc', $parsed['type']);
    }

    public function test_it_throws_for_invalid_json_like_payload(): void
    {
        $this->expectException(InvalidContentException::class);

        (new DefaultContentParser)->parse('{not-valid-json}');
    }

    public function test_it_keeps_html_as_string(): void
    {
        $parsed = (new DefaultContentParser)->parse('<p>Hello</p>');

        $this->assertSame('<p>Hello</p>', $parsed);
    }
}
