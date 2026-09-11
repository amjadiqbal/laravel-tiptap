<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap;

use AmjadIqbal\LaravelTiptap\Contracts\ContentParser;
use AmjadIqbal\LaravelTiptap\Contracts\ContentRenderer;
use AmjadIqbal\LaravelTiptap\Contracts\ContentTransformer;
use AmjadIqbal\LaravelTiptap\Contracts\Sanitizer;
use AmjadIqbal\LaravelTiptap\Editor\EditorBuilder;
use AmjadIqbal\LaravelTiptap\Extensions\ExtensionRegistry;

class Tiptap
{
    public function __construct(
        private readonly ExtensionRegistry $extensionRegistry,
        private readonly ContentParser $parser,
        private readonly ContentRenderer $renderer,
        private readonly ContentTransformer $transformer,
        private readonly Sanitizer $sanitizer,
    ) {}

    public function make(): EditorBuilder
    {
        return new EditorBuilder(
            extensionRegistry: $this->extensionRegistry,
            parser: $this->parser,
            renderer: $this->renderer,
            transformer: $this->transformer,
            sanitizer: $this->sanitizer,
        );
    }
}
