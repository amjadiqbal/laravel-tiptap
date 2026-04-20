<?php

declare(strict_types=1);

use AmjadIqbal\LaravelTiptap\Http\Controllers\TiptapUploadController;
use Illuminate\Support\Facades\Route;

if (! config('tiptap.route.enabled', true)) {
    return;
}

Route::group([
    'prefix' => config('tiptap.route.prefix', 'tiptap'),
    'middleware' => array_merge(
        config('tiptap.route.middleware', ['web']),
        ['throttle:' . config('tiptap.route.rate_limiter', 'tiptap-uploads')]
    ),
], function (): void {
    Route::post('/upload', TiptapUploadController::class)->name('tiptap.upload');
});
