<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

class StorefrontThemeCatalog
{
    protected static ?array $cache = null;

    public static function all(): array
    {
        if (static::$cache !== null) {
            return static::$cache;
        }

        $root = public_path('storefront-themes');
        $themes = [];

        if (File::isDirectory($root)) {
            foreach (File::directories($root) as $dir) {
                $slug = basename($dir);
                $jsonPath = $dir.'/theme.json';

                if (! File::exists($jsonPath)) {
                    continue;
                }

                $decoded = json_decode(File::get($jsonPath), true);
                if (! is_array($decoded)) {
                    continue;
                }

                $decoded['slug'] = $decoded['slug'] ?? $slug;
                $decoded['assets'] = [
                    'css' => File::exists($dir.'/theme.css') ? global_asset('storefront-themes/'.$slug.'/theme.css') : null,
                    'preview' => File::exists($dir.'/preview.svg') ? global_asset('storefront-themes/'.$slug.'/preview.svg') : null,
                ];

                $themes[$decoded['slug']] = $decoded;
            }
        }

        ksort($themes);

        return static::$cache = array_values($themes);
    }

    public static function slugs(): array
    {
        return array_map(fn ($t) => $t['slug'], static::all());
    }

    public static function find(string $slug): ?array
    {
        foreach (static::all() as $theme) {
            if ($theme['slug'] === $slug) {
                return $theme;
            }
        }

        return null;
    }

    public static function resolveTokens(?string $slug, $overrides = []): array
    {
        $theme = $slug ? static::find($slug) : null;
        $tokens = $theme['tokens'] ?? [];

        if (is_string($overrides)) {
            $overrides = json_decode($overrides, true) ?: [];
        }
        if (! is_array($overrides)) {
            $overrides = [];
        }

        $customizable = $theme['customizable'] ?? array_keys($tokens);

        foreach ($overrides as $key => $value) {
            if (in_array($key, $customizable, true) && is_string($value) && $value !== '') {
                $tokens[$key] = $value;
            }
        }

        return $tokens;
    }
}
