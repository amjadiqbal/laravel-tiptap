<?php

declare(strict_types=1);

use AmjadIqbal\LaravelTiptap\Extensions\BuiltInExtensions;

return [
    'route' => [
        'enabled' => true,
        'prefix' => 'tiptap',
        'middleware' => ['web', 'throttle:tiptap-uploads'],
    ],

    'upload' => [
        'disk' => env('TIPTAP_UPLOAD_DISK', env('FILESYSTEM_DISK', 'public')),
        'directory' => env('TIPTAP_UPLOAD_DIRECTORY', 'tiptap/uploads'),
        'visibility' => env('TIPTAP_UPLOAD_VISIBILITY', 'public'),
        'max_size_kb' => 5120,
        'mimes' => ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg'],
    ],

    'security' => [
        'allowed_tags' => ['p', 'br', 'strong', 'em', 'ul', 'ol', 'li', 'h1', 'h2', 'h3', 'h4', 'blockquote', 'code', 'pre', 'a', 'img', 'table', 'thead', 'tbody', 'tr', 'th', 'td'],
    ],

    'extensions' => [
        'defaults' => BuiltInExtensions::defaults(),
    ],

    'support' => [
        'issues' => 'https://github.com/amjadiqbal/laravel-tiptap/issues',
        'email' => 'support@example.com',
    ],
];
