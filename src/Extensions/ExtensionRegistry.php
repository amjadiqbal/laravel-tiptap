<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Extensions;

use AmjadIqbal\LaravelTiptap\Exceptions\InvalidExtensionException;

class ExtensionRegistry
{
    /** @var array<string, Extension> */
    private array $extensions = [];

    /** @param array<int, array<string,mixed>> $defaults */
    public function __construct(array $defaults = [])
    {
        $defaults = $defaults !== [] ? $defaults : BuiltInExtensions::defaults();

        foreach ($defaults as $extension) {
            $this->register(Extension::fromArray($extension));
        }
    }

    public function register(Extension $extension): self
    {
        if ($extension->name === '') {
            throw InvalidExtensionException::because('Extension name cannot be empty.');
        }

        $this->extensions[$extension->name] = $extension;

        return $this;
    }

    /** @param array<string,mixed> $definition */
    public function registerFromArray(array $definition): self
    {
        return $this->register(Extension::fromArray($definition));
    }

    public function resolve(string $name): Extension
    {
        if (! isset($this->extensions[$name])) {
            throw InvalidExtensionException::because("Extension [{$name}] is not registered.");
        }

        return $this->extensions[$name];
    }

    /** @return array<int, array<string,mixed>> */
    public function all(): array
    {
        return array_values(array_map(static fn (Extension $extension): array => $extension->toArray(), $this->extensions));
    }
}
