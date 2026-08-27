<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

/**
 * Reads the portable storefront theme packs shipped under
 * public/storefront-themes/<slug>/theme.json. Each pack is a self-contained,
 * framework-agnostic bundle (theme.json + theme.css + preview.svg) that only
 * depends on the storefront's shared CSS-variable design-token contract
 * (see resources/css/storefront.css) — it never touches PHP, Blade, or the
 * database directly, so the same folder can be dropped into any other
 * platform/tenant storefront that implements the same token contract.
 */
class StorefrontThemeCatalog
{
    protected static ?array $cache = null;

    /**
     * @return array<int, array> catalog entries, each the decoded theme.json
     *                            plus a resolved `assets` block.
     */
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
                    'css' => File::exists($dir.'/theme.css') ? asset('storefront-themes/'.$slug.'/theme.css') : null,
                    'preview' => File::exists($dir.'/preview.svg') ? asset('storefront-themes/'.$slug.'/preview.svg') : null,
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

    /**
     * Merge a theme's default tokens with tenant overrides, restricted to
     * the keys the theme itself declares as customizable.
     */
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
