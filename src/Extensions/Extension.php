<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Extensions;

use Illuminate\Contracts\Support\Arrayable;

/**
 * @implements Arrayable<string, mixed>
 */
class Extension implements Arrayable
{
    /** @param array<string,mixed> $config */
    public function __construct(
        public readonly string $name,
        public readonly ?string $import = null,
        public readonly array $config = [],
        public readonly bool $enabled = true,
    ) {}

    /** @param array<string,mixed> $data */
    public static function fromArray(array $data): self
    {
        return new self(
            name: (string) ($data['name'] ?? ''),
            import: isset($data['import']) ? (string) $data['import'] : null,
            config: is_array($data['config'] ?? null) ? $data['config'] : [],
            enabled: (bool) ($data['enabled'] ?? true),
        );
    }

    /** @return array<string,mixed> */
    public function toArray(): array
    {
        return [
            'name' => $this->name,
            'import' => $this->import,
            'config' => $this->config,
            'enabled' => $this->enabled,
        ];
    }
}
