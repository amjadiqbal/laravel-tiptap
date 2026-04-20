<?php

declare(strict_types=1);

namespace AmjadIqbal\LaravelTiptap\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class TiptapUploadRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        $mimes = implode(',', config('tiptap.upload.mimes', ['jpg', 'jpeg', 'png', 'gif', 'webp', 'svg']));

        return [
            'file' => [
                'required',
                'file',
                'mimes:' . $mimes,
                'max:' . (int) config('tiptap.upload.max_size_kb', 5120),
            ],
        ];
    }
}
