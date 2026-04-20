# Installation Guide

## Requirements

- PHP 8.2+
- Laravel 11+

## Install

```bash
composer require amjadiqbal/laravel-tiptap
```

## Publish config

```bash
php artisan vendor:publish --tag=tiptap-config
```

## Optional: publish views

```bash
php artisan vendor:publish --tag=tiptap-views
```

## Frontend dependencies

Install Tiptap packages used by your frontend stack, for example:

```bash
npm install @tiptap/core @tiptap/starter-kit
```
