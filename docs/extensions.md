# Extension Creation Guide

## Register custom extension

```php
use AmjadIqbal\LaravelTiptap\Extensions\Extension;
use AmjadIqbal\LaravelTiptap\Extensions\ExtensionRegistry;

app(ExtensionRegistry::class)->register(new Extension(
    name: 'Mention',
    import: '@tiptap/extension-mention',
    config: ['HTMLAttributes' => ['class' => 'mention']]
));
```

## Use extension in builder

```php
Tiptap::make()->extensions(['StarterKit', 'Mention']);
```

## Notes

- PHP defines extension metadata and options.
- Frontend resolves `import` dynamically and applies `configure(...)` with `config`.
- This approach keeps feature parity with Tiptap extension capability while staying backend-driven.
