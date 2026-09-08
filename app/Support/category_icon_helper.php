<?php

/**
 * Maps a category's display name to one of the icon names understood by
 * <x-store.icon>, so storefront "Shop by Category" rows/grids can show a
 * real glyph instead of a first-letter avatar. Category names are
 * free-text (admin-entered, or from the industry catalog seeder), so this
 * is a best-effort keyword match with a generic fallback -- it never
 * fails or errors for an unrecognized name.
 */
if (!function_exists('category_icon_name')) {
    function category_icon_name(?string $categoryName): string
    {
        $name = strtolower((string) $categoryName);

        $map = [
            'gem'      => ['jewelry', 'watch', 'luxury'],
            'shirt'    => ['fashion', 'apparel', 'cloth', 'footwear', 'shoe'],
            'sparkles' => ['beauty', 'cosmetic', 'skincare', 'makeup'],
            'cpu'      => ['electronic', 'gadget', 'tech'],
            'basket'   => ['grocery', 'produce', 'fresh', 'supermarket'],
            'dumbbell' => ['fitness', 'gym', 'supplement'],
            'cup'      => ['beverage', 'drink', 'coffee', 'tea'],
            'cookie'   => ['snack'],
            'book'     => ['book', 'media'],
            'pencil'   => ['stationery', 'office supp'],
            'utensils' => ['restaurant', 'food', 'cafe', 'delivery', 'kitchen'],
            'paw'      => ['pet'],
            'package'  => ['wholesale', 'b2b'],
            'wrench'   => ['auto', 'hardware', 'tool'],
            'monitor'  => ['digital', 'software'],
            'pill'     => ['pharmacy', 'medical', 'health'],
            'bag'      => ['marketplace', 'retail', 'general'],
        ];

        foreach ($map as $icon => $keywords) {
            foreach ($keywords as $keyword) {
                if (str_contains($name, $keyword)) {
                    return $icon;
                }
            }
        }

        return 'grid';
    }
}
