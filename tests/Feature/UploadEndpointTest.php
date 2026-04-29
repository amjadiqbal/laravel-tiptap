<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Tests\Feature;

use AmjadIqbal\LaravelTiptap\Tests\TestCase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;

class UploadEndpointTest extends TestCase
{
    public function test_it_uploads_file_and_returns_json_contract(): void
    {
        Storage::fake('public');
        config()->set('tiptap.upload.disk', 'public');

        $response = $this->postJson(route('tiptap.upload'), [
            'file' => UploadedFile::fake()->image('example.jpg'),
        ]);

        $response->assertOk()
            ->assertJsonStructure([
                'success',
                'url',
                'path',
                'name',
                'mime',
                'size',
            ]);
    }
}
