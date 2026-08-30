<?php

namespace App\Support\Storefront;

use App\Models\Product;
use App\Models\StoreBanner;
use App\Models\Category;
use Illuminate\Support\Str;

/**
 * Centralizes the "row -> Blade view-model" shaping that used to be
 * duplicated per-theme in every partials/product-card.blade.php (pricing,
 * discount, tax, stock, SKU fallback, variant payload). Theme partials
 * should only render this array — no business logic in theme files.
 *
 * NOTE: the field names/shape here intentionally mirror the data-* attribute
 * contract already consumed by resources/src/storefront.js (js-quick-view /
 * js-add-to-cart), so existing cart/quick-view JS keeps working unchanged.
 */
class StorefrontPresenter
{
    protected const PLACEHOLDER_COLORS = [
        '#2857E0', '#1CB672', '#F0800F', '#6D3FE0', '#E5484D', '#0EA5A5',
    ];

    /**
     * @param  Product  $p  Expects variants/images/category/brand to already
     *                      be eager-loaded where available; display_price and
     *                      stock should already be attached by the controller
     *                      (attachStockToProducts / the price SQL pipeline),
     *                      matching current behavior — this presenter re-uses
     *                      whatever the controller already computed instead
     *                      of recomputing the SQL price pipeline in PHP.
     */
    public static function product(Product $p, string $currency, bool $hidePrices = false): array
    {
        $slug = $p->slug ?? (string) $p->id;

        $galleryFilenames = method_exists($p, 'productGalleryFilenames') ? $p->productGalleryFilenames() : [];
        $galleryUrls = collect($galleryFilenames)
            ->map(fn ($f) => $f ? global_asset(upload_path('products').'/'.$f) : null)
            ->filter()
            ->values()
            ->all();

        $primaryFile = method_exists($p, 'primaryProductImageFilename') ? $p->primaryProductImageFilename() : '';
        $imageUrl = $primaryFile
            ? global_asset(upload_path('products').'/'.$primaryFile)
            : null;

        $finalPrice = (float) ($p->display_price ?? $p->price ?? 0);
        $basePrice = (float) ($p->base_price ?? $p->price ?? 0);
        $discountPercent = $basePrice > 0 && $finalPrice < $basePrice
            ? (int) round((($basePrice - $finalPrice) / $basePrice) * 100)
            : 0;

        $variants = collect($p->relationLoaded('variants') ? $p->variants : ($p->variants ?? []));
        $variantPayload = $variants->map(function ($v) use ($currency) {
            $final = (float) ($v->display_price ?? $v->price ?? 0);

            return [
                'id' => (int) ($v->id ?? 0),
                'name' => (string) ($v->name ?? ''),
                'price' => (float) ($v->price ?? 0),
                'display_price' => $final,
                'display_price_formatted' => $currency.number_format($final, 2, '.', ','),
                'image' => ! empty($v->image) ? global_asset(upload_path('products').'/'.$v->image) : null,
                'stock' => (int) max(0, $v->stock ?? $v->qty ?? 0),
            ];
        })->values();

        $productStock = $variants->isEmpty() ? (int) max(0, $p->stock ?? 0) : null;

        $isPreorder = (bool) ($p->is_preorder ?? false);
        $outOfStock = $variants->isEmpty()
            ? ($productStock !== null && $productStock <= 0)
            : ! $variantPayload->contains(fn ($v) => ($v['stock'] ?? 0) > 0);
        $isPreorderActive = $isPreorder && $outOfStock;
        $isAvailable = $isPreorderActive || ! $outOfStock;

        $stockStatus = $isPreorderActive ? 'preorder' : ($isAvailable ? ($productStock !== null && $productStock <= 5 && $productStock > 0 ? 'low_stock' : 'in_stock') : 'out_of_stock');

        $warrantyText = null;
        if (! empty($p->warranty_period)) {
            $warrantyText = $p->warranty_period.' '.($p->warranty_unit ?: 'Mo').' Warranty';
        } elseif (! empty($p->has_guarantee)) {
            $warrantyText = 'Official Guarantee';
        }

        $categoryName = null;
        if ($p->relationLoaded('category') && $p->category) {
            $categoryName = $p->category->name;
        } elseif ($p->relationLoaded('categories') && $p->categories->isNotEmpty()) {
            $categoryName = $p->categories->first()->name;
        }

        return [
            'id' => (int) $p->id,
            'slug' => $slug,
            'sku' => $p->code ?: ('SKU-'.str_pad((string) $p->id, 5, '0', STR_PAD_LEFT)),
            'name' => (string) $p->name,
            'description' => Str::limit(strip_tags($p->note ?? ''), 600),
            'url' => route('store.product.show', ['slugOrId' => $slug]),
            'image_url' => $imageUrl,
            'gallery_urls' => $galleryUrls,
            'placeholder_color' => static::placeholderColor($p->id),
            'currency' => $currency,
            'final_price' => $finalPrice,
            'final_price_formatted' => $currency.number_format($finalPrice, 2, '.', ','),
            'compare_at_price' => $discountPercent > 0 ? $basePrice : null,
            'compare_at_price_formatted' => $discountPercent > 0 ? $currency.number_format($basePrice, 2, '.', ',') : null,
            'discount_percent' => $discountPercent,
            'is_on_sale' => $discountPercent > 0,
            'hide_prices' => $hidePrices,
            'stock' => $productStock,
            'stock_status' => $stockStatus,
            'is_available' => $isAvailable,
            'is_preorder' => $isPreorder,
            'is_preorder_active' => $isPreorderActive,
            'preorder_date' => $p->preorder_available_date ? $p->preorder_available_date->format('M d, Y') : null,
            'warranty_text' => $warrantyText,
            'brand_name' => $p->relationLoaded('brand') && $p->brand ? $p->brand->name : null,
            'category_name' => $categoryName,
            'weight' => $p->weight ?? null,
            'variants' => $variantPayload->all(),
            'is_featured' => (bool) ($p->is_featured ?? false),
        ];
    }

    public static function banner(StoreBanner $b): array
    {
        return [
            'id' => (int) $b->id,
            'title' => (string) ($b->title ?? ''),
            'link' => $b->link ?: null,
            'position' => (string) $b->position,
            'image_url' => $b->image_url ?? global_asset($b->image ?: upload_path('banners').'/no-image.png'),
        ];
    }

    public static function category(Category $c): array
    {
        return [
            'id' => (int) $c->id,
            'name' => (string) $c->name,
            'url' => route('store.shop', ['category' => $c->id]),
            'subcategories' => ($c->subcategories ?? collect())->map(fn ($s) => [
                'id' => (int) $s->id,
                'name' => (string) $s->name,
                'url' => route('store.shop', ['category' => $c->id, 'sub_category' => $s->id]),
            ])->values()->all(),
        ];
    }

    protected static function placeholderColor(int $seed): string
    {
        $colors = static::PLACEHOLDER_COLORS;

        return $colors[$seed % count($colors)];
    }
}
