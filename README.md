# Laravel Tiptap

A modern Laravel (11+) package for Tiptap with backend-driven editor configuration, secure upload handling, and Blade/Vue/React integrations.

## Why this package

- Fluent PHP builder mirroring core Tiptap editor options
- Dynamic extension registry for built-in and custom extensions
- Command/event/input-rule/paste-rule serialization for frontend execution
- JSON-first content handling with parser, transformer, and sanitizer contracts
- Secure upload endpoint with validation, CSRF, and rate limiting

## Installation

```bash
composer require amjadiqbal/laravel-tiptap
```

```bash
php artisan vendor:publish --tag=tiptap-config
```

## Quick Start

```php
use AmjadIqbal\LaravelTiptap\Facades\Tiptap;

$config = Tiptap::make()
    ->extensions(['StarterKit', 'Bold', 'Italic', 'Link'])
    ->content(['type' => 'doc', 'content' => []])
    ->editable(true)
    ->autofocus('end')
    ->editorProps(['attributes' => ['class' => 'prose']])
    ->parseOptions(['preserveWhitespace' => true])
    ->toArray();
```

```blade
<x-tiptap-editor name="content" id="editor" :content="$post->content" />
```

## Built-in extension definitions

- StarterKit
- Bold, Italic, Heading
- Image, Link, CodeBlock
- Table
- BulletList, OrderedList, ListItem

## Upload endpoint

`POST /tiptap/upload`

Response shape:

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

- Sanitization contract and default HTML sanitizer
- Upload MIME and max-size validation
- CSRF protections via `web` middleware
- Named rate limiter for uploads (`tiptap-uploads`)

## Diagnostics

```bash
php artisan tiptap:debug
```

## Contributor test requirements

- Package runtime support: PHP 8.2+
- Local package test tooling (PHPUnit 11/12): PHP 8.2+

## Documentation

- [Installation Guide](docs/installation.md)
- [Usage Examples](docs/usage.md)
- [Extension Creation Guide](docs/extensions.md)
- [API Reference](docs/api-reference.md)
- [Analysis of Existing Packages](docs/analysis-existing-packages.md)
- [Changelog](CHANGELOG.md)

## CI/CD and versioning

- CI workflow runs tests, Laravel Pint, and PHPStan on PHP 8.2 and 8.3
- Release workflow triggers on semantic version tags (`v*.*.*`)

## Support

- Issues: https://github.com/AmjadIqbal/laravel-tiptap/issues
- Email: hi@amjad.com.pk

## Community

- [Contributing Guide](CONTRIBUTING.md)
- [Code of Conduct](CODE_OF_CONDUCT.md)
- Buy Me a Coffee: https://www.buymeacoffee.com/amjadiqbal
- GitHub Sponsors: https://github.com/sponsors/amjadiqbal

## License

MIT

## Author

**Amjad Iqbal** — [amjad.com.pk](https://amjad.com.pk) · [hi@amjad.com.pk](mailto:hi@amjad.com.pk) · [GitHub](https://github.com/AmjadIqbal)
