# Changelog

All notable changes to `laravel-tiptap` are documented in this file.

The format is based on [Keep a Changelog](https://keepachangelog.com/en/1.0.0/),
and this project adheres to [Semantic Versioning](https://semver.org/spec/v2.0.0.html).

## [1.0.1] - 2026-09-19

Found and fixed during manual integration testing against a fresh Laravel 13 / PHP 8.5
install (before publishing to Laravel News).

### Fixed
- **`composer require amjadiqbal/laravel-tiptap` failed on the current Laravel release.**
  `illuminate/contracts|support|http|routing` were capped at `^11.0|^12.0`; a fresh
  Laravel 13 app pulls in `illuminate/*` `^13.x`, so resolution failed. The package's
  code has no Laravel-13-specific incompatibility (verified: full test suite, Pint and
  PHPStan level 6 all still pass unchanged), so this was a stale ceiling. Widened all
  four to also accept `^13.0`.
- **`<x-tiptap-editor>`'s hidden form field submitted the wrong value for plain string
  content.** `resources/views/components/editor.blade.php` rendered the hidden input's
  `value` with `@json($config['options']['content'] ?? null)`. For the common case —
  `content` is a plain HTML string, e.g. `<p>hi</p>` — `@json()` wraps it in a literal
  JSON string, producing `value='"<p>hi</p>"'` (quote characters included). Submitting
  the form back to the server therefore delivered the string `"<p>hi</p>"`, not
  `<p>hi</p>` — a real corruption of the saved content on every plain-text/HTML use of
  the component, reproduced by rendering the component and inspecting the output HTML.
  Array content (Tiptap JSON docs) still needs JSON encoding to round-trip correctly, so
  the fix branches on `is_array()`: arrays are still `json_encode()`d, strings are now
  emitted as-is (through Blade's normal HTML-attribute escaping).

Manually verified after the fixes: `composer require` against a real Laravel 13 project,
`Tiptap::make()->toArray()` via the facade on a real route, `tiptap:debug`, and
`<x-tiptap-editor>` rendered from a real Blade view — the hidden input's value now
round-trips the original content exactly.

## [1.0.0] - 2026-09-11

First tagged release. The package had been on Packagist since April 2026 without a
version tag; this release formalizes what was already shipping as 1.0.

### Added
- Fluent `EditorBuilder` mirroring Tiptap's core editor options (extensions, content,
  editable/autofocus, editor props, parse options, keyboard shortcuts, input/paste
  rules, commands, events).
- Dynamic extension registry for built-in and custom Tiptap extensions.
- JSON-first content pipeline: parser, renderer, transformer and sanitizer contracts
  with sane defaults (`DefaultContentParser`, `DefaultContentRenderer`,
  `DefaultContentTransformer`, `HtmlSanitizer`).
- Secure upload endpoint (`TiptapUploadController`) with validation, configurable
  disk/directory/visibility, optional auth requirement, and CSRF protection via
  Laravel's routing stack.
- Blade component (`<x-tiptap-editor>`) and facade (`Tiptap::make()`).
- `tiptap:debug` Artisan command.
- Full docs under `docs/` (installation, usage, extensions, API reference).

### Fixed
- CI now passes cleanly: added missing generic array/`Arrayable` value types so
  `phpstan analyse` (level 6) reports zero errors; ran Laravel Pint's fixers so
  `composer pint` (the CI check) passes; gave the PHPUnit/Orchestra Testbench app an
  encryption key in `tests/TestCase.php` so the two upload tests stop failing with
  `MissingAppKeyException`.
- `composer.lock` was pinned to PHPUnit 12.5.23, which itself requires PHP >=8.3 —
  breaking `composer install` on the PHP 8.2 leg of the CI matrix even though the
  package declares `"php": "^8.2"`. Widened the dev constraint to
  `phpunit/phpunit: "^11.3|^12.0.1"`, pinned `config.platform.php` to `8.2.0` so
  future `composer update` runs resolve against the declared floor regardless of the
  machine running them, and regenerated the lock file. `composer install` now
  succeeds on both PHP 8.2 and PHP 8.3 from a clean `vendor/`.

### Known limitations
- `composer audit` reports three `laravel/framework` advisories (CRLF injection in
  the framework's own email validation rule) that are unpatched anywhere in the
  11.x line this package's dev test harness (`orchestra/testbench ^9.0`) pins to.
  This only affects the local test harness — nothing shipped in `src/` touches that
  code path, and no laravel/framework version is a runtime dependency of this
  package. Tracked here rather than silently ignored; will clear once
  `orchestra/testbench` is bumped to a Laravel 12/13-based major.
