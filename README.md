# Laravel Tiptap

Professional Laravel (11+) package for Tiptap with fluent backend configuration, secure upload handling, and Blade/Vue/React integration.

## Installation

```bash
composer require amjadiqbal/laravel-tiptap
```

Publish config:

```bash
php artisan vendor:publish --tag=tiptap-config
```

## Quick Start

```php
use AmjadIqbal\LaravelTiptap\Facades\Tiptap;

$config = Tiptap::make()
    ->extensions(['StarterKit', 'Bold', 'Italic'])
    ->content(['type' => 'doc', 'content' => []])
    ->editable(true)
    ->autofocus('end')
    ->editorProps(['attributes' => ['class' => 'prose']])
    ->parseOptions(['preserveWhitespace' => true])
    ->toArray();
```

## Blade

```blade
<x-tiptap-editor name="content" id="post-content" :content="$post->content" />
```

## Vue 3 / React

Use components in `resources/js/vue/TiptapEditor.vue` and `resources/js/react/TiptapEditor.jsx` with backend config payload.

## Upload API

`POST /tiptap/upload` (web + throttle middleware) returns:

```json
{
  "success": true,
  "url": "...",
  "path": "...",
  "name": "...",
  "mime": "...",
  "size": 1234
}
```

## Security

- Content sanitization support
- Upload MIME and size validation
- CSRF via web middleware
- Rate limiting via throttle middleware

## Artisan Support

```bash
php artisan tiptap:debug
```

## Support

- Issues: https://github.com/amjadiqbal/laravel-tiptap/issues
- Email: support@example.com

## Community

- Buy Me a Coffee: https://www.buymeacoffee.com/amjadiqbal
- GitHub Sponsors: https://github.com/sponsors/amjadiqbal

## License

MIT
