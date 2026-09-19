@props(['name' => 'content', 'id' => 'tiptap-editor', 'model' => null, 'config' => []])

@php($contentValue = $config['options']['content'] ?? null)

<div
    id="{{ $id }}"
    data-tiptap='@json($config)'
    data-model="{{ $model ?? '' }}"
></div>

<input type="hidden" name="{{ $name }}" value="{{ is_array($contentValue) ? json_encode($contentValue) : (string) ($contentValue ?? '') }}">
