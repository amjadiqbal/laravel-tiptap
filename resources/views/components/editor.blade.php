@props(['name' => 'content', 'id' => 'tiptap-editor', 'model' => null, 'config' => []])

<div
    id="{{ $id }}"
    data-tiptap='@json($config)'
    data-model="{{ $model ?? '' }}"
></div>

<input type="hidden" name="{{ $name }}" value='@json($config["options"]["content"] ?? null)'>
