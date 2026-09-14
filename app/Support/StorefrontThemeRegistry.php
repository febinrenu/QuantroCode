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

                $raw = File::get($jsonPath);
                $raw = preg_replace('/^\xEF\xBB\xBF/', '', $raw);
                $decoded = json_decode($raw, true);
                if (! is_array($decoded)) {
                    continue;
                }

                $decoded['slug'] = $decoded['slug'] ?? $slug;
                $decoded['directory'] = $slug;
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

    public static function normalizeSlug(?string $slug): ?string
    {
        if (! $slug) {
            return null;
        }
        $aliases = [
            'aurumeclat-jewelry' => 'aurumeclat',
            'verde-living' => 'verde',
            'generalhub-mega' => 'generalhub-store',
            'novatech-tech' => 'novatech-electronics',
            'technova-electronics' => 'technova-audio',
            'voguelane-fashion' => 'voguelane-couture',
            'zanova-marketplace' => 'zanova-flash',
        ];
        return $aliases[$slug] ?? $slug;
    }

    public static function find(string $slug): ?array
    {
        $normalized = static::normalizeSlug($slug);
        foreach (static::all() as $theme) {
            if ($theme['slug'] === $normalized || $theme['slug'] === $slug) {
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

        $themeDir = $theme['directory'] ?? $theme['slug'];

        if (isset($theme['pages'][$page]) && ! $theme['pages'][$page]) {
            return false;
        }

        return File::exists(resource_path("views/store/themes/{$themeDir}/{$page}.blade.php"));
    }

    /**
     * Resolve the Blade view name for a theme's page, or null if the theme
     * doesn't have that page (caller should fall back to the generic view).
     */
    public static function viewFor(?string $slug, string $page): ?string
    {
        $theme = $slug ? static::find($slug) : null;
        if (! $theme || ! static::hasPage($slug, $page)) {
            return null;
        }

        $themeDir = $theme['directory'] ?? $theme['slug'];
        return "store.themes.{$themeDir}.{$page}";
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

    /**
     * Which of the 6 canonical banner positions (top_left, top_right,
     * center_left, center_right, footer_left, footer_right) a theme's
     * home.blade.php actually renders -- audited directly against each
     * theme's Blade file (grep for `$byPos[...]` usage, including the
     * few themes that build the position dynamically from a PHP array
     * of tiles rather than a literal string). Themes not listed here render
     * none (no banner-grid section exists in their homepage at all), so the
     * admin UI can tell a merchant "this theme has no banner section" instead
     * of offering slots that would silently do nothing.
     */
    protected const BANNER_POSITIONS = [
        'aurumeclat' => ['top_left', 'top_right'],
        'brutalex' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'casanest' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'casanest-furniture' => ['top_left', 'top_right', 'center_left'],
        'crystalglass' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'elegance' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'elegance-boutique' => ['top_left', 'top_right'],
        'freshcart' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'freshcart-daily' => ['top_left', 'top_right'],
        'futurex' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'futurex-tech' => [],
        'generalhub' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'generalhub-store' => ['top_left', 'top_right'],
        'homely' => ['top_left', 'top_right'],
        'littlejoy-kids' => ['top_left', 'top_right', 'center_left', 'center_right'],
        'marketly-shop' => [],
        'marketverse' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'marketverse-deals' => ['top_left', 'top_right', 'center_left'],
        'medisphere-care' => ['top_left', 'top_right'],
        'monochra' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'naturae' => ['top_left', 'top_right', 'center_left', 'center_right', 'footer_left', 'footer_right'],
        'naturae-wellness' => ['top_left', 'top_right', 'center_left'],
        'naturia-living' => ['top_left', 'top_right', 'center_left'],
        'nexora' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'nexora-trending' => ['top_left', 'top_right'],
        'novatech' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'novatech-electronics' => ['top_left', 'top_right', 'center_left'],
        'paperloom' => ['top_left', 'top_right', 'center_left'],
        'retropop' => ['top_left', 'top_right', 'center_left', 'center_right', 'footer_left', 'footer_right'],
        'shopiq' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'technova' => ['top_left', 'top_right', 'center_left', 'footer_left', 'footer_right'],
        'technova-audio' => ['top_left', 'top_right', 'center_left'],
        'terraco' => ['top_left', 'top_right'],
        'terraco-market' => ['top_left', 'top_right', 'center_left', 'center_right', 'footer_left'],
        'urbana' => ['top_left', 'top_right', 'center_left', 'center_right', 'footer_left', 'footer_right'],
        'urbana-lifestyle' => ['top_left'],
        'urbanic' => ['top_left', 'top_right', 'center_left', 'center_right', 'footer_left'],
        'veloura' => ['top_left', 'top_right', 'center_left', 'center_right', 'footer_left', 'footer_right'],
        'veloura-beauty' => ['top_left', 'top_right', 'center_left'],
        'verde' => ['top_left'],
        'voguelane' => ['top_left', 'top_right', 'footer_left', 'footer_right'],
        'voguelane-couture' => ['top_left', 'top_right', 'center_left', 'center_right', 'footer_left'],
        'zanova' => ['top_left', 'top_right', 'center_left', 'center_right', 'footer_left', 'footer_right'],
        'zanova-flash' => ['top_left', 'top_right', 'center_left', 'center_right', 'footer_left'],
    ];

    public static function bannerPositions(?string $slug): array
    {
        $slug = static::normalizeSlug($slug);

        return static::BANNER_POSITIONS[$slug] ?? [];
    }
}
