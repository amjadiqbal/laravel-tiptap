<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Tests\Feature;

use AmjadIqbal\LaravelTiptap\Tests\TestCase;
use Illuminate\Http\UploadedFile;

class UploadAuthorizationTest extends TestCase
{
    public function test_guest_is_forbidden_when_upload_auth_is_required(): void
    {
        config()->set('tiptap.upload.require_auth', true);

        $response = $this->postJson(route('tiptap.upload'), [
            'file' => UploadedFile::fake()->image('example.jpg'),
        ]);

        $this->assertContains($response->getStatusCode(), [401, 403]);
    }
}
