<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Foundation\Application;

class TiptapDebugCommand extends Command
{
    protected $signature = 'tiptap:debug';

    protected $description = 'Show Laravel Tiptap diagnostic information';

    public function handle(): int
    {
        $this->table(['Key', 'Value'], [
            ['Laravel Version', Application::VERSION],
            ['PHP Version', PHP_VERSION],
            ['Package Version', $this->packageVersion()],
            ['Route Prefix', (string) config('tiptap.route.prefix')],
            ['Upload Disk', (string) config('tiptap.upload.disk')],
            ['Support Issues', (string) config('tiptap.support.issues')],
            ['Support Email', (string) config('tiptap.support.email')],
        ]);

        return self::SUCCESS;
    }

    private function packageVersion(): string
    {
        $composerPath = __DIR__ . '/../../../composer.json';
        if (! is_file($composerPath)) {
            return 'unknown';
        }

        $contents = file_get_contents($composerPath);
        if ($contents === false) {
            return 'unknown';
        }

        $composer = json_decode($contents, true);

        return is_array($composer) ? ($composer['version'] ?? 'dev-main') : 'unknown';
    }
}
