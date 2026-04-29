<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Tests\Feature;

use AmjadIqbal\LaravelTiptap\Tests\TestCase;

class DebugCommandTest extends TestCase
{
    public function test_debug_command_runs_successfully(): void
    {
        $this->artisan('tiptap:debug')
            ->assertExitCode(0);
    }
}
