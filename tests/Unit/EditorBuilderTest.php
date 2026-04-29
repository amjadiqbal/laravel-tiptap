<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Tests\Unit;

use AmjadIqbal\LaravelTiptap\Facades\Tiptap;
use AmjadIqbal\LaravelTiptap\Tests\TestCase;

class EditorBuilderTest extends TestCase
{
    public function test_it_builds_editor_configuration(): void
    {
        $config = Tiptap::make()
            ->extensions(['StarterKit', 'Bold'])
            ->content(['type' => 'doc', 'content' => []])
            ->editable(true)
            ->autofocus('start')
            ->editorProps(['attributes' => ['class' => 'editor']])
            ->parseOptions(['preserveWhitespace' => true])
            ->keyboardShortcut('Mod-b', 'toggleBold')
            ->inputRule(['name' => 'dash'])
            ->pasteRule(['name' => 'url'])
            ->on('onUpdate', 'handleUpdate')
            ->focus('end')
            ->toArray();

        $this->assertSame(true, $config['options']['editable']);
        $this->assertSame('start', $config['options']['autofocus']);
        $this->assertCount(2, $config['extensions']);
        $this->assertArrayHasKey('Mod-b', $config['keyboardShortcuts']);
        $this->assertCount(1, $config['commands']);
    }
}
