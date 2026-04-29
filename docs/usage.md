# Usage Examples

## Fluent editor builder

```php
use AmjadIqbal\LaravelTiptap\Facades\Tiptap;

$config = Tiptap::make()
    ->extensions(['StarterKit', 'Bold', 'Italic', 'Link'])
    ->content(['type' => 'doc', 'content' => []])
    ->editable(true)
    ->autofocus('start')
    ->editorProps(['attributes' => ['class' => 'prose max-w-none']])
    ->parseOptions(['preserveWhitespace' => true])
    ->plugin(['name' => 'customPlugin'])
    ->keyboardShortcuts(['Mod-b' => 'toggleBold'])
    ->inputRules([['name' => 'smartQuotes']])
    ->pasteRules([['name' => 'urlPasteRule']])
    ->on('onUpdate', 'postEditorUpdated')
    ->toArray();
```

## Blade

```blade
<x-tiptap-editor
    name="content"
    id="editor"
    :content="$post->content"
    :extensions="['StarterKit', 'Image', 'Table']"
/>
```

## Upload endpoint

Use `route('tiptap.upload')` as the image upload target in your frontend editor integration.
