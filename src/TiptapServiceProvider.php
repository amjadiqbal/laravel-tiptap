<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap;

use AmjadIqbal\LaravelTiptap\Console\Commands\TiptapDebugCommand;
use AmjadIqbal\LaravelTiptap\Contracts\ContentParser as ContentParserContract;
use AmjadIqbal\LaravelTiptap\Contracts\ContentRenderer as ContentRendererContract;
use AmjadIqbal\LaravelTiptap\Contracts\ContentTransformer as ContentTransformerContract;
use AmjadIqbal\LaravelTiptap\Contracts\Sanitizer;
use AmjadIqbal\LaravelTiptap\Extensions\ExtensionRegistry;
use AmjadIqbal\LaravelTiptap\Support\DefaultContentParser;
use AmjadIqbal\LaravelTiptap\Support\DefaultContentRenderer;
use AmjadIqbal\LaravelTiptap\Support\DefaultContentTransformer;
use AmjadIqbal\LaravelTiptap\Support\HtmlSanitizer;
use AmjadIqbal\LaravelTiptap\View\Components\TiptapEditor;
use Illuminate\Support\Facades\Blade;
use Illuminate\Support\Facades\RateLimiter;
use Illuminate\Support\ServiceProvider;
use Illuminate\Cache\RateLimiting\Limit;

class TiptapServiceProvider extends ServiceProvider
{
    public function register(): void
    {
        $this->mergeConfigFrom(__DIR__ . '/../config/tiptap.php', 'tiptap');

        $this->app->singleton(Sanitizer::class, fn (): HtmlSanitizer => new HtmlSanitizer(config('tiptap.security.allowed_tags', [])));
        $this->app->singleton(ContentParserContract::class, DefaultContentParser::class);
        $this->app->singleton(ContentRendererContract::class, DefaultContentRenderer::class);
        $this->app->singleton(ContentTransformerContract::class, DefaultContentTransformer::class);
        $this->app->singleton(ExtensionRegistry::class, fn (): ExtensionRegistry => new ExtensionRegistry(config('tiptap.extensions.defaults', [])));

        $this->app->singleton(Tiptap::class, function ($app): Tiptap {
            return new Tiptap(
                $app->make(ExtensionRegistry::class),
                $app->make(ContentParserContract::class),
                $app->make(ContentRendererContract::class),
                $app->make(ContentTransformerContract::class),
                $app->make(Sanitizer::class)
            );
        });
    }

    public function boot(): void
    {
        RateLimiter::for((string) config('tiptap.route.rate_limiter', 'tiptap-uploads'), static function () {
            return Limit::perMinute((int) config('tiptap.route.uploads_per_minute', 30));
        });

        $this->loadViewsFrom(__DIR__ . '/../resources/views', 'laravel-tiptap');
        $this->loadRoutesFrom(__DIR__ . '/../routes/tiptap.php');

        Blade::component('tiptap-editor', TiptapEditor::class);

        if ($this->app->runningInConsole()) {
            $this->publishes([
                __DIR__ . '/../config/tiptap.php' => config_path('tiptap.php'),
            ], 'tiptap-config');

            $this->publishes([
                __DIR__ . '/../resources/views' => resource_path('views/vendor/laravel-tiptap'),
            ], 'tiptap-views');

            $this->commands([
                TiptapDebugCommand::class,
            ]);
        }
    }
}
