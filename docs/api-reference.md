# API Reference

## Main entry

- `Tiptap::make(): EditorBuilder`

## EditorBuilder methods

- `extensions(array $extensions)`
- `addExtension(string|array|Extension $extension)`
- `content(array|string|null $content)`
- `editable(bool $editable = true)`
- `autofocus(bool|int|string $autofocus = true)`
- `editorProps(array $props)`
- `parseOptions(array $options)`
- `injectCss(bool $enabled = true)`
- `injectNonce(?string $nonce)`
- `textDirection(?string $direction)`
- `enableInputRules(bool $enabled = true)`
- `enablePasteRules(bool $enabled = true)`
- `enableCoreExtensions(bool|array $enabled = true)`
- `enableContentCheck(bool $enabled = true)`
- `plugin(array $plugin)` / `plugins(array $plugins)`
- `keyboardShortcut(string $key, string $command)` / `keyboardShortcuts(array $map)`
- `inputRule(array $rule)` / `inputRules(array $rules)`
- `pasteRule(array $rule)` / `pasteRules(array $rules)`
- `on(string $event, ?string $handler = null)` / `events(array $events)`
- `command(string $name, array $payload = [])`
- `chain(): CommandChain`
- `setContent(array|string|null $content, bool $emitUpdate = true)`
- `focus(null|bool|int|string $position = null)`
- `blur()`
- `clearContent(bool $emitUpdate = true)`
- `renderHTML(): string`
- `transform(string $targetFormat, array $context = []): mixed`
- `toArray(): array`

## Artisan command

- `php artisan tiptap:debug`
