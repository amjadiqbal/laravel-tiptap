<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Http\Controllers;

use AmjadIqbal\LaravelTiptap\Http\Requests\TiptapUploadRequest;
use Illuminate\Http\JsonResponse;
use Illuminate\Routing\Controller;
use Illuminate\Support\Facades\Storage;

class TiptapUploadController extends Controller
{
    public function __invoke(TiptapUploadRequest $request): JsonResponse
    {
        $disk = (string) config('tiptap.upload.disk', config('filesystems.default'));
        $directory = (string) config('tiptap.upload.directory', 'tiptap/uploads');
        $visibility = (string) config('tiptap.upload.visibility', 'public');

        $file = $request->file('file');
        $path = $file->store($directory, ['disk' => $disk, 'visibility' => $visibility]);

        return response()->json([
            'success' => true,
            // @phpstan-ignore-next-line method.notFound (Filesystem contract omits url(); concrete adapters implement it)
            'url' => Storage::disk($disk)->url($path),
            'path' => $path,
            'name' => $file->getClientOriginalName(),
            'mime' => $file->getClientMimeType(),
            'size' => $file->getSize(),
        ]);
    }
}
