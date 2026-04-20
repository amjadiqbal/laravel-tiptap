<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Extensions;

class BuiltInExtensions
{
    /** @return array<int, array<string,mixed>> */
    public static function defaults(): array
    {
        return [
            ['name' => 'StarterKit', 'import' => '@tiptap/starter-kit', 'config' => []],
            ['name' => 'Bold', 'import' => '@tiptap/extension-bold', 'config' => []],
            ['name' => 'Italic', 'import' => '@tiptap/extension-italic', 'config' => []],
            ['name' => 'Heading', 'import' => '@tiptap/extension-heading', 'config' => []],
            ['name' => 'Image', 'import' => '@tiptap/extension-image', 'config' => []],
            ['name' => 'Link', 'import' => '@tiptap/extension-link', 'config' => []],
            ['name' => 'CodeBlock', 'import' => '@tiptap/extension-code-block', 'config' => []],
            ['name' => 'Table', 'import' => '@tiptap/extension-table', 'config' => []],
            ['name' => 'BulletList', 'import' => '@tiptap/extension-bullet-list', 'config' => []],
            ['name' => 'OrderedList', 'import' => '@tiptap/extension-ordered-list', 'config' => []],
            ['name' => 'ListItem', 'import' => '@tiptap/extension-list-item', 'config' => []],
        ];
    }
}
