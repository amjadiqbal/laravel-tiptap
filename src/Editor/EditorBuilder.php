<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Editor;

use AmjadIqbal\LaravelTiptap\Commands\Command;
use AmjadIqbal\LaravelTiptap\Commands\CommandChain;
use AmjadIqbal\LaravelTiptap\Contracts\ContentParser;
use AmjadIqbal\LaravelTiptap\Contracts\ContentRenderer;
use AmjadIqbal\LaravelTiptap\Contracts\ContentTransformer;
use AmjadIqbal\LaravelTiptap\Contracts\Sanitizer;
use AmjadIqbal\LaravelTiptap\Events\EventMap;
use AmjadIqbal\LaravelTiptap\Extensions\Extension;
use AmjadIqbal\LaravelTiptap\Extensions\ExtensionRegistry;
use Illuminate\Contracts\Support\Arrayable;
use JsonSerializable;

/**
 * @implements Arrayable<string, mixed>
 */
class EditorBuilder implements Arrayable, JsonSerializable
{
    /** @var array<int, array<string, mixed>> */
    private array $extensions = [];

    /** @var array<string, mixed> */
    private array $options = [];

    /** @var array<int, array<string, mixed>> */
    private array $plugins = [];

    /** @var array<string, string> */
    private array $keyboardShortcuts = [];

    /** @var array<int, array<string, mixed>> */
    private array $inputRules = [];

    /** @var array<int, array<string, mixed>> */
    private array $pasteRules = [];

    private EventMap $events;

    private CommandChain $chain;

    public function __construct(
        private readonly ExtensionRegistry $extensionRegistry,
        private readonly ContentParser $parser,
        private readonly ContentRenderer $renderer,
        private readonly ContentTransformer $transformer,
        private readonly Sanitizer $sanitizer,
    ) {
        $this->events = new EventMap;
        $this->chain = new CommandChain;
        $this->options = [
            'editable' => true,
            'autofocus' => false,
            'injectCSS' => true,
            'enableInputRules' => true,
            'enablePasteRules' => true,
            'enableCoreExtensions' => true,
            'enableContentCheck' => false,
        ];
    }

    /** @param array<int, string|array<string,mixed>|Extension> $extensions */
    public function extensions(array $extensions): self
    {
        $this->extensions = [];

        foreach ($extensions as $extension) {
            $this->addExtension($extension);
        }

        return $this;
    }

    /** @param array<string,mixed>|Extension|string $extension */
    public function addExtension(string|array|Extension $extension): self
    {
        if ($extension instanceof Extension) {
            $resolved = $extension;
        } elseif (is_string($extension)) {
            $resolved = $this->extensionRegistry->resolve($extension);
        } else {
            $resolved = Extension::fromArray($extension);
        }

        $this->extensions[] = $resolved->toArray();

        return $this;
    }

    /** @param array<string,mixed>|string|null $content */
    public function content(array|string|null $content): self
    {
        $this->options['content'] = $this->parser->parse($content);

        return $this;
    }

    public function editable(bool $editable = true): self
    {
        $this->options['editable'] = $editable;

        return $this;
    }

    public function autofocus(bool|int|string $autofocus = true): self
    {
        $this->options['autofocus'] = $autofocus;

        return $this;
    }

    /** @param array<string,mixed> $props */
    public function editorProps(array $props): self
    {
        $this->options['editorProps'] = $props;

        return $this;
    }

    /** @param array<string,mixed> $options */
    public function parseOptions(array $options): self
    {
        $this->options['parseOptions'] = $options;

        return $this;
    }

    public function injectCss(bool $enabled = true): self
    {
        $this->options['injectCSS'] = $enabled;

        return $this;
    }

    public function injectNonce(?string $nonce): self
    {
        $this->options['injectNonce'] = $nonce;

        return $this;
    }

    public function textDirection(?string $direction): self
    {
        $this->options['textDirection'] = $direction;

        return $this;
    }

    public function enableInputRules(bool $enabled = true): self
    {
        $this->options['enableInputRules'] = $enabled;

        return $this;
    }

    public function enablePasteRules(bool $enabled = true): self
    {
        $this->options['enablePasteRules'] = $enabled;

        return $this;
    }

    /** @param bool|array<int,string> $enabled */
    public function enableCoreExtensions(bool|array $enabled = true): self
    {
        $this->options['enableCoreExtensions'] = $enabled;

        return $this;
    }

    public function enableContentCheck(bool $enabled = true): self
    {
        $this->options['enableContentCheck'] = $enabled;

        return $this;
    }

    /** @param array<string,mixed> $plugin */
    public function plugin(array $plugin): self
    {
        $this->plugins[] = $plugin;

        return $this;
    }

    /** @param array<int,array<string,mixed>> $plugins */
    public function plugins(array $plugins): self
    {
        foreach ($plugins as $plugin) {
            $this->plugin($plugin);
        }

        return $this;
    }

    public function keyboardShortcut(string $key, string $command): self
    {
        $this->keyboardShortcuts[$key] = $command;

        return $this;
    }

    /** @param array<string,string> $map */
    public function keyboardShortcuts(array $map): self
    {
        foreach ($map as $key => $command) {
            $this->keyboardShortcut($key, $command);
        }

        return $this;
    }

    /** @param array<string,mixed> $rule */
    public function inputRule(array $rule): self
    {
        $this->inputRules[] = $rule;

        return $this;
    }

    /** @param array<int,array<string,mixed>> $rules */
    public function inputRules(array $rules): self
    {
        foreach ($rules as $rule) {
            $this->inputRule($rule);
        }

        return $this;
    }

    /** @param array<string,mixed> $rule */
    public function pasteRule(array $rule): self
    {
        $this->pasteRules[] = $rule;

        return $this;
    }

    /** @param array<int,array<string,mixed>> $rules */
    public function pasteRules(array $rules): self
    {
        foreach ($rules as $rule) {
            $this->pasteRule($rule);
        }

        return $this;
    }

    public function on(string $event, ?string $handler = null): self
    {
        $this->events->set($event, $handler);

        return $this;
    }

    /** @param array<string, string|null> $events */
    public function events(array $events): self
    {
        foreach ($events as $event => $handler) {
            $this->on($event, $handler);
        }

        return $this;
    }

    /** @param array<string,mixed> $payload */
    public function command(string $name, array $payload = []): self
    {
        $this->chain->push(new Command($name, $payload));

        return $this;
    }

    public function chain(): CommandChain
    {
        return $this->chain;
    }

    /** @param array<string,mixed>|string|null $content */
    public function setContent(array|string|null $content, bool $emitUpdate = true): self
    {
        return $this->command('setContent', [
            'content' => $this->parser->parse($content),
            'emitUpdate' => $emitUpdate,
        ]);
    }

    public function focus(null|bool|int|string $position = null): self
    {
        return $this->command('focus', ['position' => $position]);
    }

    public function blur(): self
    {
        return $this->command('blur');
    }

    public function clearContent(bool $emitUpdate = true): self
    {
        return $this->command('clearContent', ['emitUpdate' => $emitUpdate]);
    }

    public function renderHTML(): string
    {
        return $this->renderer->render($this->options['content'] ?? null, $this->toArray());
    }

    /** @param array<string,mixed> $context */
    public function transform(string $targetFormat, array $context = []): mixed
    {
        return $this->transformer->transform($this->options['content'] ?? null, $targetFormat, $context);
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'options' => $this->options,
            'extensions' => $this->extensions,
            'plugins' => $this->plugins,
            'keyboardShortcuts' => $this->keyboardShortcuts,
            'inputRules' => $this->inputRules,
            'pasteRules' => $this->pasteRules,
            'events' => $this->events->toArray(),
            'commands' => $this->chain->toArray(),
            'sanitizedContent' => $this->sanitizer->sanitize($this->options['content'] ?? null),
        ];
    }

    /** @return array<string,mixed> */
    public function jsonSerialize(): array
    {
        return $this->toArray();
    }
}
