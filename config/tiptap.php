<?php

declare(strict_types=1);

use AmjadIqbal\LaravelTiptap\Extensions\BuiltInExtensions;

return [
    'route' => [
        'enabled' => true,
        'prefix' => 'tiptap',
        'middleware' => ['web'],
        'rate_limiter' => 'tiptap-uploads',
        'uploads_per_minute' => 30,
    ],

    'upload' => [
        'disk' => env('TIPTAP_UPLOAD_DISK', env('FILESYSTEM_DISK', 'public')),
        'directory' => env('TIPTAP_UPLOAD_DIRECTORY', 'tiptap/uploads'),
        'visibility' => env('TIPTAP_UPLOAD_VISIBILITY', 'public'),
        'require_auth' => (bool) env('TIPTAP_UPLOAD_REQUIRE_AUTH', false),
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
        'email' => env('TIPTAP_SUPPORT_EMAIL', 'amjadiqbal@users.noreply.github.com'),
    ],
];
