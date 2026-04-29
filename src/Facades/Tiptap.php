<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @method static \AmjadIqbal\LaravelTiptap\Editor\EditorBuilder make()
 */
class Tiptap extends Facade
{
    protected static function getFacadeAccessor(): string
    {
        return \AmjadIqbal\LaravelTiptap\Tiptap::class;
    }
}
