<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\View\Components;

use AmjadIqbal\LaravelTiptap\Facades\Tiptap;
use Illuminate\Contracts\View\View;
use Illuminate\View\Component;

class TiptapEditor extends Component
{
    /** @param array<int, string|array<string,mixed>> $extensions */
    public function __construct(
        public readonly string $name = 'content',
        public readonly string $id = 'tiptap-editor',
        public readonly ?string $model = null,
        public readonly array|string|null $content = null,
        public readonly array $extensions = [],
        public readonly bool $editable = true,
    ) {
    }

    public function render(): View
    {
        $editor = Tiptap::make()
            ->content($this->content)
            ->editable($this->editable)
            ->extensions($this->extensions === [] ? config('tiptap.extensions.defaults', []) : $this->extensions);

        return view('laravel-tiptap::components.editor', [
            'config' => $editor->toArray(),
        ]);
    }
}
