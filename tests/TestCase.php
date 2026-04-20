<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Tests;

use AmjadIqbal\LaravelTiptap\TiptapServiceProvider;
use Orchestra\Testbench\TestCase as Orchestra;

abstract class TestCase extends Orchestra
{
    protected function getPackageProviders($app): array
    {
        return [TiptapServiceProvider::class];
    }

    protected function defineEnvironment($app): void
    {
        $app['config']->set('database.default', 'testing');
        $app['config']->set('filesystems.default', 'local');
        $app['config']->set('filesystems.disks.local.root', __DIR__ . '/tmp-storage');
    }
}
