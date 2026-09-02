<?php

namespace App\Support;

use Illuminate\Support\Facades\File;

/**
 * Registry for the 20 unified storefront themes living under
 * resources/views/store/themes/{slug}/theme.json. Replaces the old
 * StorefrontThemeCatalog (which scanned public/storefront-themes for the
 * now-retired color-token-only themes).
 */
class StorefrontThemeRegistry
{
    protected static ?array $cache = null;

    public static function all(): array
    {
        if (static::$cache !== null) {
            return static::$cache;
        }

        $root = resource_path('views/store/themes');
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
     * Lighten (positive $percent) or darken (negative) a hex color, so a
     * theme shell can derive hover/deep/soft variants from a single
     * customizable base color instead of leaving those shades stuck at
     * their original hardcoded default when the base is customized.
     */
    public static function shade(string $hex, float $percent): string
    {
        $hex = ltrim($hex, '#');
        if (strlen($hex) === 3) {
            $hex = $hex[0].$hex[0].$hex[1].$hex[1].$hex[2].$hex[2];
        }
        if (! preg_match('/^[0-9a-fA-F]{6}$/', $hex)) {
            return '#'.$hex;
        }

        [$r, $g, $b] = array_map('hexdec', str_split($hex, 2));
        $mix = function ($c) use ($percent) {
            $target = $percent < 0 ? 0 : 255;

            return (int) round($c + ($target - $c) * abs($percent));
        };

        return sprintf('#%02x%02x%02x', $mix($r), $mix($g), $mix($b));
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

    /**
     * Whether the given theme declares (and ships a Blade file for) the given page.
     * $page is one of: home, shop, product, cart.
     */
    public static function hasPage(?string $slug, string $page): bool
    {
        if (! $slug) {
            return false;
        }

        $theme = static::find($slug);
        if (! $theme) {
            return false;
        }

        if (isset($theme['pages'][$page]) && ! $theme['pages'][$page]) {
            return false;
        }

        return File::exists(resource_path("views/store/themes/{$slug}/{$page}.blade.php"));
    }

    /**
     * Resolve the Blade view name for a theme's page, or null if the theme
     * doesn't have that page (caller should fall back to the generic view).
     */
    public static function viewFor(?string $slug, string $page): ?string
    {
        if (! static::hasPage($slug, $page)) {
            return null;
        }

        return "store.themes.{$slug}.{$page}";
    }

    /**
     * The `categories.code` a category-specific theme is locked to (see
     * theme.json's "restrict_category_code"), or null for a general-purpose
     * theme. StoreFrontController uses this to force every product query
     * (home, shop) to that one category regardless of request params.
     */
    public static function restrictedCategoryCode(?string $slug): ?string
    {
        if (! $slug) {
            return null;
        }

        $theme = static::find($slug);
        $code = $theme['restrict_category_code'] ?? null;

        return is_string($code) && $code !== '' ? $code : null;
    }
}
