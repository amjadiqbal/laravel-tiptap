<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Tests\Unit;

use AmjadIqbal\LaravelTiptap\Exceptions\InvalidExtensionException;
use AmjadIqbal\LaravelTiptap\Extensions\Extension;
use AmjadIqbal\LaravelTiptap\Extensions\ExtensionRegistry;
use PHPUnit\Framework\TestCase;

class ExtensionRegistryTest extends TestCase
{
    public function test_it_registers_and_resolves_custom_extension(): void
    {
        $registry = new ExtensionRegistry([]);
        $registry->register(new Extension('Mention', '@tiptap/extension-mention', ['foo' => 'bar']));

        $resolved = $registry->resolve('Mention');

        $this->assertSame('Mention', $resolved->name);
    }

    public function test_it_throws_for_unknown_extension(): void
    {
        $this->expectException(InvalidExtensionException::class);

        (new ExtensionRegistry([]))->resolve('Unknown');
    }

    public function test_it_rejects_unsafe_import_paths(): void
    {
        $this->expectException(InvalidExtensionException::class);

        (new ExtensionRegistry([]))->register(new Extension('Unsafe', 'https://malicious.example/ext.js'));
    }
}
