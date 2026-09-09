<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Collection;
use App\Models\Product;
use App\Models\StoreBanner;
use App\Models\StoreSetting;
use App\Support\StorefrontThemeRegistry;
use App\Support\Storefront\StorefrontPresenter;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Schema;
use DB;
use Illuminate\Http\Request;

class StoreFrontController extends Controller
{
    /**
     * Authoritative product code prefixes for the 14 Category-Specific Themes.
     */
    public const CATEGORY_THEME_PREFIXES = [
        'aurumeclat'           => 'JWL-',
        'aurumeclat-jewelry'   => 'JWL-',
        'generalhub'           => 'GEN-',
        'generalhub-store'     => 'GEN-',
        'generalhub-mega'      => 'GEN-',
        'homely'               => 'HOM-',
        'marketverse'          => 'MKT-',
        'marketverse-deals'    => 'MKT-',
        'naturae'              => 'NAT-',
        'naturae-wellness'     => 'NAT-',
        'nexora'               => 'NEX-',
        'nexora-trending'      => 'NEX-',
        'novatech'             => 'NVT-',
        'novatech-electronics' => 'NVT-',
        'novatech-tech'        => 'NVT-',
        'paperloom'            => 'PPL-',
        'technova'             => 'TNV-',
        'technova-audio'       => 'TNV-',
        'technova-electronics' => 'TNV-',
        'urbanic'              => 'URB-',
        'veloura'              => 'VEL-',
        'veloura-beauty'       => 'VEL-',
        'verde'                => 'VRD-',
        'verde-living'         => 'VRD-',
        'voguelane'            => 'VOG-',
        'voguelane-couture'    => 'VOG-',
        'voguelane-fashion'    => 'VOG-',
        'zanova'               => 'ZNV-',
        'zanova-flash'         => 'ZNV-',
        'zanova-marketplace'   => 'ZNV-',
    ];

    /**
     * Resolve the active theme, honoring explicit query preview and prioritizing persisted DB theme.
     */
    protected function resolveActiveTheme(Request $request, ?StoreSetting $s = null): string
    {
        $s = $s ?: StoreSetting::first();
        $defaultTheme = $s->theme ?? 'monochra';

        $preview = $request->get('preview_theme');
        if ($preview !== null && $preview !== '') {
            if (in_array($preview, ['none', 'reset', 'default', 'clear'], true)) {
                if (session()) {
                    session()->forget('preview_theme');
                }
                return $defaultTheme;
            }
            $normalized = StorefrontThemeRegistry::normalizeSlug((string) $preview);
            if (StorefrontThemeRegistry::find($normalized)) {
                return $normalized;
            }
        }

        // When visiting the storefront normally without an explicit preview_theme query parameter,
        // always prioritize the persisted database theme and clear any stale preview session.
        if (session()) {
            session()->forget('preview_theme');
        }

        return $defaultTheme;
    }

    /**
     * Homepage — blocks driven by StoreSetting->homepage_lineup.
     */
    public function index(Request $request)
    {
        $s = StoreSetting::firstOrFail();

        $activeTheme = $this->resolveActiveTheme($request, $s);

        // Theme switch: when the Real Estate theme is active, the storefront
        // homepage is served by the dedicated real estate controller. This keeps
        // the default eCommerce storefront untouched.
        if ($activeTheme === 'real_estate') {
            return app(RealEstateStoreController::class)->home($request);
        }

        // 1) Load lineup (already cast to array by StoreSetting::$casts)
        $lineup = is_array($s->homepage_lineup) ? $s->homepage_lineup : [];

        // 2) Legacy fallback (home_collections -> lineup)
        if (empty($lineup)) {
            $legacy = $s->home_collections ?? [];
            if (is_string($legacy)) {
                $legacy = json_decode($legacy, true) ?: [];
            }
            if ($legacy) {
                $rows = collect($legacy)
                    ->filter(fn ($r) => is_array($r) && ! empty($r['collection_id']) && (
                        ! array_key_exists('visible', $r)
                        || filter_var($r['visible'], FILTER_VALIDATE_BOOLEAN, FILTER_NULL_ON_FAILURE) !== false
                    ))
                    ->sortBy(fn ($r) => (int) ($r['sort_order'] ?? 9999))
                    ->values();

                $ids = $rows->pluck('collection_id')->map(fn ($v) => (int) $v)->unique()->all();
                $idToSlug = $ids ? Collection::whereIn('id', $ids)->pluck('slug', 'id')->toArray() : [];

                $lineup = [];
                foreach ($rows as $r) {
                    $slug = (string) ($idToSlug[(int) $r['collection_id']] ?? '');
                    if ($slug === '') {
                        continue;
                    }
                    $limit = max(1, (int) ($r['limit'] ?? 8));
                    $lineup[] = [
                        'type' => 'collection',
                        'slug' => $slug,
                        'limit' => $limit,
                        'layout' => 'grid',
                        'title_override' => '',
                    ];
                }
            }
        }

        // ===== Shared price SQL (mirrors shop()) =====
        [$minVariantSub, $baseExpr, $afterDiscountExpr, $finalExpr] = $this->priceSqlExpressions();

        // 3) Build blocks
        $blocks = [];
        $defaultTaxRate = (float) ($s->default_tax_rate ?? 0);

        foreach ($lineup as $i => $item) {
            if (! is_array($item) || empty($item['type'])) {
                continue;
            }
            $type = strtolower((string) $item['type']);

            if ($type === 'hero') {
                $blocks[] = [
                    'type' => 'hero',
                    'title' => $s->hero_title ?? null,
                    'subtitle' => $s->hero_subtitle ?? null,
                    'image' => $s->hero_image_path ?? null,
                    'cfg' => ['index' => $i],
                ];

                continue;
            }

            if ($type === 'newsletter') {
                $blocks[] = [
                    'type' => 'newsletter',
                    'title' => __('Newsletter'),
                    'cfg' => ['index' => $i],
                ];

                continue;
            }

            if ($type === 'collection') {
                $slug = trim((string) ($item['slug'] ?? ($item['handle'] ?? '')));
                if ($slug === '') {
                    continue;
                }

                $limit = max(1, (int) ($item['limit'] ?? 8));
                $layout = in_array(($item['layout'] ?? 'grid'), ['grid', 'carousel'], true) ? $item['layout'] : 'grid';
                $titleOverride = trim((string) ($item['title_override'] ?? ''));

                $collection = Collection::where('slug', $slug)->first()
                    ?: (is_numeric($slug) ? Collection::find((int) $slug) : null);
                if (! $collection) {
                    continue;
                }

                $colTitle = $titleOverride !== '' ? $titleOverride : ($collection->title ?? $collection->name ?? $slug);

                // === Use the same SQL pipeline as shop(), scoped to this collection ===
                $products = Product::query()
                    ->where('products.is_active', 1)
                    ->where('products.hide_from_online_store', 0)
                    ->with([
                        'variants:id,product_id,name,price,image',
                        'images:id,product_id,image_path,is_main,sort_order',
                    ]) // QuickView / gallery + variant picker
                    ->join('collection_product', 'collection_product.product_id', '=', 'products.id')
                    ->where('collection_product.collection_id', $collection->id)
                    ->leftJoinSub($minVariantSub, 'pvmin', function ($join) {
                        $join->on('pvmin.product_id', '=', 'products.id');
                    })
                    ->addSelect(
                        'products.*',
                        DB::raw("$baseExpr AS base_price"),
                        DB::raw("$afterDiscountExpr AS after_discount"),
                        DB::raw("$finalExpr AS final_display_price")
                    )
                    ->orderBy('collection_product.sort_order')
                    ->orderBy('products.created_at', 'desc')
                    ->take($limit)
                    ->get();

                // Attach display_price to product (from SQL) AND compute each variant's display price (PHP)
                foreach ($products as $p) {
                    // Product display price from SQL
                    $p->display_price = (float) ($p->final_display_price ?? 0);

                    // Variant display prices computed with same rules as SQL
                    $taxRate = is_numeric($p->TaxNet) ? (float) $p->TaxNet : $defaultTaxRate;
                    $discVal = is_numeric($p->discount) ? (float) $p->discount : 0.0;
                    $isPercent = (string) $p->discount_method === '1';
                    $isInclusive = (string) $p->tax_method === '2';

                    if ($p->relationLoaded('variants') && $p->variants) {
                        foreach ($p->variants as $v) {
                            $price = (float) ($v->price ?? 0);
                            // discount
                            if ($discVal > 0) {
                                $price = $isPercent ? ($price - ($price * $discVal / 100)) : ($price - min($discVal, $price));
                                if ($price < 0) {
                                    $price = 0;
                                }
                            }
                            // tax
                            if (! $isInclusive && $taxRate > 0) {
                                $price = $price * (1 + $taxRate / 100);
                            }
                            $v->display_price = round($price, 2);
                        }
                    }
                }

                $this->attachStockToProducts($products, $s->default_warehouse_id);

                if ($s->hide_out_of_stock ?? false) {
                    $products = $products->filter(fn ($p) => $this->productHasStock($p));
                }

                $blocks[] = [
                    'type' => 'collection',
                    'title' => $colTitle,
                    'collection' => $collection,
                    'products' => $products, // each $p has display_price, stock; each variant has display_price, stock
                    'cfg' => [
                        'limit' => $limit,
                        'layout' => $layout,
                        'index' => $i,
                    ],
                ];
            }
        }

        // 4) Active banners
        $banners = StoreBanner::query()
            ->where('active', 1)
            ->whereIn('position', ['top_left', 'top_right', 'center_left', 'center_right', 'footer_left', 'footer_right'])
            ->orderBy('position')
            ->orderBy('updated_at', 'desc')
            ->get();

        foreach ($banners as $b) {
            $b->image_url = global_asset($b->image ?: upload_path('banners').'/no-image.png');
        }

        $categories = $this->getThemedCategories($activeTheme);

        // Category-specific themes (see restrict_category_code in their
        // theme.json) get their homepage's featured-products section fed
        // directly from their one locked category -- these themes don't
        // depend on an admin having pre-configured a homepage Collection,
        // since the whole point is to work out of the box for that category.
        $restrictedCategoryCode = StorefrontThemeRegistry::restrictedCategoryCode($activeTheme);
        $categorySpecificProducts = collect();
        if ($restrictedCategoryCode) {
            $restrictedCategoryId = Category::where('code', $restrictedCategoryCode)->value('id');
            if ($restrictedCategoryId) {
                // Category-specific themes only ever show their one locked
                // category, so the header's "Shop by Category" menu should
                // only offer that category too -- not the full store catalog.
                $categories = $categories->where('id', $restrictedCategoryId)->values();

                $hidePrices = ! Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);
                $currency = $s->currency_code ?? '$';

                $featured = Product::query()
                    ->where('is_active', 1)
                    ->where('hide_from_online_store', 0)
                    ->where('category_id', $restrictedCategoryId)
                    ->with(['variants:id,product_id,name,price,image', 'images:id,product_id,image_path,is_main,sort_order', 'category:id,name'])
                    ->leftJoinSub($minVariantSub, 'pvmin', function ($join) {
                        $join->on('pvmin.product_id', '=', 'products.id');
                    })
                    ->addSelect(
                        'products.*',
                        DB::raw("$baseExpr AS base_price"),
                        DB::raw("$afterDiscountExpr AS after_discount"),
                        DB::raw("$finalExpr AS final_display_price")
                    )
                    ->orderBy('products.created_at', 'desc')
                    ->take(6)
                    ->get();

                foreach ($featured as $p) {
                    $p->display_price = (float) ($p->final_display_price ?? 0);
                }
                $this->attachStockToProducts($featured, $s->default_warehouse_id);

                $categorySpecificProducts = $featured->map(
                    fn ($p) => StorefrontPresenter::product($p, $currency, $hidePrices)
                );

                // One representative product photo per subcategory, so a
                // theme's "Women" tile shows an actual Women's-Fashion-tagged
                // product instead of whichever of the category's newest
                // products happens to land on that tile by position. A
                // product can be tagged to more than one subcategory (e.g.
                // "Designer Sneakers" is both Men and Shoes), so this picks
                // the newest product NOT already used by an earlier
                // subcategory first, only reusing one if that subcategory
                // has no other tagged product with a photo -- otherwise two
                // sibling tiles would show the exact same picture.
                $subcategoryImages = [];
                $usedProductIds = [];
                foreach ($categories->first()->subcategories ?? [] as $subcat) {
                    $candidates = Product::query()
                        ->where('is_active', 1)
                        ->where('hide_from_online_store', 0)
                        ->whereNotNull('image')
                        ->where('image', '!=', '')
                        ->where('image', '!=', 'no-image.png')
                        ->where(function ($q) use ($subcat) {
                            $q->where('sub_category_id', $subcat->id)
                                ->orWhereExists(function ($sub) use ($subcat) {
                                    $sub->select(DB::raw(1))
                                        ->from('product_subcategory')
                                        ->whereColumn('product_subcategory.product_id', 'products.id')
                                        ->where('product_subcategory.sub_category_id', $subcat->id);
                                });
                        })
                        ->orderBy('created_at', 'desc')
                        ->limit(10)
                        ->get(['id', 'image']);

                    $pick = $candidates->first(fn ($p) => ! in_array($p->id, $usedProductIds, true)) ?? $candidates->first();

                    if ($pick) {
                        $usedProductIds[] = $pick->id;
                        $subcategoryImages[$subcat->name] = global_asset(upload_path('products').'/'.$pick->image);
                    }
                }
            }
        }

        $viewData = [
            's' => $s,
            'blocks' => $blocks,
            'categories' => $categories,
            'subcategoryImages' => $subcategoryImages ?? [],
            'banners' => $banners,
            'showCategoryBar' => true,
            'categorySpecificProducts' => $categorySpecificProducts,
        ];

        $themePrefix = self::CATEGORY_THEME_PREFIXES[$activeTheme] ?? null;
        if ($themePrefix !== null) {
            $themedProductsQuery = Product::query()
                ->where('products.deleted_at', '=', null)
                ->where('products.is_active', 1)
                ->where('products.hide_from_online_store', 0)
                ->where('products.code', 'like', $themePrefix . '%')
                ->with(['variants', 'images', 'category', 'brand'])
                ->leftJoinSub($minVariantSub, 'pvmin', function ($join) {
                    $join->on('pvmin.product_id', '=', 'products.id');
                })
                ->addSelect(
                    'products.*',
                    DB::raw("$baseExpr AS base_price"),
                    DB::raw("$afterDiscountExpr AS after_discount"),
                    DB::raw("$finalExpr AS final_display_price")
                );

            if ($activeTheme === 'novatech-electronics' || $activeTheme === 'novatech' || $activeTheme === 'novatech-tech') {
                $themedProductsQuery->orderByRaw("CASE WHEN products.code IN ('NVT-EAR-001', 'NVT-WAT-002', 'NVT-LAP-003', 'NVT-PHN-004', 'NVT-CAM-005', 'NVT-SPK-006', 'NVT-GAM-007', 'NVT-HED-008', 'NVT-BAN-009', 'NVT-LAP-010', 'NVT-PHN-011', 'NVT-CAM-012', 'NVT-MOU-013', 'NVT-ACC-014', 'NVT-ACC-015', 'NVT-SMH-016') THEN FIELD(products.code, 'NVT-EAR-001', 'NVT-WAT-002', 'NVT-LAP-003', 'NVT-PHN-004', 'NVT-CAM-005', 'NVT-SPK-006', 'NVT-GAM-007', 'NVT-HED-008', 'NVT-BAN-009', 'NVT-LAP-010', 'NVT-PHN-011', 'NVT-CAM-012', 'NVT-MOU-013', 'NVT-ACC-014', 'NVT-ACC-015', 'NVT-SMH-016') ELSE 99 END");
            } elseif ($activeTheme === 'zanova-flash' || $activeTheme === 'zanova' || $activeTheme === 'zanova-marketplace') {
                $themedProductsQuery->orderByRaw("CASE WHEN products.code IN ('ZNV-EAR-001', 'ZNV-WAT-002', 'ZNV-CAM-003', 'ZNV-SPK-004', 'ZNV-BAK-005', 'ZNV-MIX-006', 'ZNV-LAP-007', 'ZNV-HED-008', 'ZNV-MOU-009', 'ZNV-FRY-010', 'ZNV-YOG-011', 'ZNV-SRM-012') THEN FIELD(products.code, 'ZNV-EAR-001', 'ZNV-WAT-002', 'ZNV-CAM-003', 'ZNV-SPK-004', 'ZNV-BAK-005', 'ZNV-MIX-006', 'ZNV-LAP-007', 'ZNV-HED-008', 'ZNV-MOU-009', 'ZNV-FRY-010', 'ZNV-YOG-011', 'ZNV-SRM-012') ELSE 99 END");
            } else {
                $themedProductsQuery->orderBy('products.is_featured', 'desc')
                                    ->orderBy('products.created_at', 'desc');
            }

            $products = $themedProductsQuery->take(24)->get();
            $viewData['products'] = $products;
            $viewData['categorySpecificProducts'] = $products;
        }

        $view = StorefrontThemeRegistry::viewFor($activeTheme, 'home') ?? 'store.index';

        return view($view, $viewData);
    }

    /**
     * Shop â€” products with filters.
     * Sorting/filters use base "effective_price" (min variant or product price).
     * UI shows final display price (discount + tax) computed per item after fetch.
     */

     public function shop(Request $request)
    {
        $s = StoreSetting::firstOrFail();

        $activeTheme = $this->resolveActiveTheme($request, $s);
        $restrictedCategoryCode = StorefrontThemeRegistry::restrictedCategoryCode($activeTheme);
        $restrictedCategoryId = $restrictedCategoryCode
            ? \App\Models\Category::where('code', $restrictedCategoryCode)->value('id')
            : null;

        $q = trim((string) $request->get('q', ''));
        // Category-specific themes ignore the request's own category/collection
        // params and always show only their one locked category.
        $cat = $restrictedCategoryId ?: $request->get('category');
        // Subcategory filtering still applies for category-specific themes --
        // it only narrows further within the one locked category, so a
        // theme's "Women / Men / Dresses / ..." nav can filter for real.
        $subCat = $request->get('sub_category');
        $minPrice = $request->get('min');
        $maxPrice = $request->get('max');
        $sort = $request->get('sort', 'latest');   // latest|price_asc|price_desc
        $coll = $request->get('collection');       // id or slug
        $brand = trim((string) $request->get('brand', ''));

        // 1-2) Shared price SQL pipeline (mirrors index())
        [$minVariantSub, $baseExpr, $afterDiscountExpr, $finalExpr] = $this->priceSqlExpressions();

        $productsQuery = Product::query()
            ->where('deleted_at', '=', null)
            ->where('is_active', 1)
            ->where('hide_from_online_store', 0)
            // Note: product_variants table doesn't have a `qty` column; stock comes from product_warehouse.qte
            ->with([
                'variants:id,product_id,name,price,image',
                'images:id,product_id,image_path,is_main,sort_order',
            ]) // Quick View / gallery + picker
            ->leftJoinSub($minVariantSub, 'pvmin', function ($join) {
                $join->on('pvmin.product_id', '=', 'products.id');
            })
            ->addSelect(
                'products.*',
                DB::raw("$baseExpr AS base_price"),
                DB::raw("$afterDiscountExpr AS after_discount"),
                DB::raw("$finalExpr AS final_display_price")   // <= final price for filter/sort/UI
            );

        if ($s->hide_out_of_stock && $s->default_warehouse_id) {
            $inStockIds = $this->getInStockProductIds((int) $s->default_warehouse_id);
            $productsQuery->whereIn('products.id', $inStockIds);
        }

        $categories = $this->getThemedCategories($activeTheme);

        $themePrefix = self::CATEGORY_THEME_PREFIXES[$activeTheme] ?? null;
        if ($themePrefix !== null) {
            $productsQuery->where('products.code', 'like', $themePrefix . '%');
        }

        $products = $productsQuery
            // Search
            ->when($q !== '', function ($qb) use ($q) {
                $qb->where('products.name', 'like', "%{$q}%");
            })
            // Brand filter
            ->when($brand !== '', function ($qb) use ($brand) {
                $qb->where(function ($q) use ($brand) {
                    $q->whereHas('brand', function ($bq) use ($brand) {
                        $bq->where('name', $brand)
                           ->orWhere('name', 'like', "%{$brand}%");
                    })
                    ->orWhere('products.name', 'like', "%{$brand}%");
                });
            })
            // Category (legacy column OR category_product pivot OR name/slug match)
            ->when($cat, function ($qb) use ($cat) {
                if (is_numeric($cat)) {
                    $cid = (int) $cat;
                    $qb->where(function ($q) use ($cid) {
                        $q->where('products.category_id', $cid);
                        if (Schema::hasTable('category_product')) {
                            $q->orWhereExists(function ($sub) use ($cid) {
                                $sub->select(DB::raw(1))
                                    ->from('category_product')
                                    ->whereColumn('category_product.product_id', 'products.id')
                                    ->where('category_product.category_id', $cid);
                            });
                        }
                    });
                } else {
                    $norm = trim((string) $cat);
                    $matchedCatIds = Category::where('name', $norm)
                        ->orWhere('code', $norm)
                        ->orWhere('name', 'like', "%{$norm}%")
                        ->orWhere('code', 'like', "%{$norm}%")
                        ->pluck('id')
                        ->all();

                    if (!empty($matchedCatIds)) {
                        $qb->where(function ($q) use ($matchedCatIds) {
                            $q->whereIn('products.category_id', $matchedCatIds);
                            if (Schema::hasTable('category_product')) {
                                $q->orWhereExists(function ($sub) use ($matchedCatIds) {
                                    $sub->select(DB::raw(1))
                                        ->from('category_product')
                                        ->whereColumn('category_product.product_id', 'products.id')
                                        ->whereIn('category_product.category_id', $matchedCatIds);
                                });
                            }
                        });
                    }
                }
            })
            // Sub Category (legacy column OR product_subcategory pivot)
            ->when($subCat, function ($qb) use ($subCat) {
                $sid = (int) $subCat;
                $qb->where(function ($q) use ($sid) {
                    $q->where('products.sub_category_id', $sid);
                    if (Schema::hasTable('product_subcategory')) {
                        $q->orWhereExists(function ($sub) use ($sid) {
                            $sub->select(DB::raw(1))
                                ->from('product_subcategory')
                                ->whereColumn('product_subcategory.product_id', 'products.id')
                                ->where('product_subcategory.sub_category_id', $sid);
                        });
                    }
                });
            })
            // Price range (by final price)
            ->when(is_numeric($minPrice), function ($qb) use ($finalExpr, $minPrice) {
                $qb->whereRaw("$finalExpr >= ?", [(float) $minPrice]);
            })
            ->when(is_numeric($maxPrice), function ($qb) use ($finalExpr, $maxPrice) {
                $qb->whereRaw("$finalExpr <= ?", [(float) $maxPrice]);
            })
            // Collection: id or slug
            ->when($coll, function ($qb) use ($coll) {
                $qb->whereHas('collections', function ($rel) use ($coll) {
                    if (is_numeric($coll)) {
                        $rel->where('collections.id', (int) $coll);
                    } else {
                        $slugs = [(string) $coll, str_replace('-', '_', (string) $coll), str_replace('_', '-', (string) $coll)];
                        if (in_array($coll, ['bestselling', 'bestseller', 'bestsellers', 'best-sellers', 'best_sellers', 'best-seller', 'top-rated'])) {
                            $slugs = array_merge($slugs, ['bestselling', 'bestseller', 'bestsellers', 'best-sellers', 'best_sellers', 'top-rated']);
                        }
                        if (in_array($coll, ['new-arrivals', 'new_arrivals', 'new-in', 'new_in', 'new', 'latest'])) {
                            $slugs = array_merge($slugs, ['new-arrivals', 'new_arrivals', 'new-in', 'new_in', 'new', 'latest']);
                        }
                        if (in_array($coll, ['study-essentials', 'study_essentials', 'essentials'])) {
                            $slugs = array_merge($slugs, ['study-essentials', 'study_essentials', 'essentials']);
                        }
                        if (in_array($coll, ['flash-sale', 'flash_sale', 'sale', 'deals'])) {
                            $slugs = array_merge($slugs, ['flash-sale', 'flash_sale', 'sale', 'deals']);
                        }
                        if (in_array($coll, ['top-deals', 'top_deals'])) {
                            $slugs = array_merge($slugs, ['top-deals', 'top_deals', 'deals', 'sale']);
                        }
                        if (in_array($coll, ['recommended', 'recommended-for-you', 'recommended_for_you'])) {
                            $slugs = array_merge($slugs, ['recommended', 'recommended-for-you', 'recommended_for_you', 'featured']);
                        }
                        $rel->whereIn('collections.slug', array_unique($slugs));
                    }
                });
            });

        // Sort
        if ($sort === 'price_asc') {
            $products->orderByRaw("$finalExpr ASC");
        } elseif ($sort === 'price_desc') {
            $products->orderByRaw("$finalExpr DESC");
        } else {
            $products->orderBy('products.created_at', 'desc');
        }

        $products = $products->paginate(12)->withQueryString();
        $collections = Collection::orderBy('title')
            ->get(['id', 'title', 'slug'])
            ->map(function ($c) {
                $c->title = $c->title ?: ($c->name ?? '');

                return $c;
            });

        // Attach display_price for the Blade (use SQL-computed final_display_price)
        foreach ($products as $p) {
            $p->display_price = (float) ($p->final_display_price ?? 0);
        }
        $this->attachStockToProducts($products, $s->default_warehouse_id);

        $view = StorefrontThemeRegistry::viewFor($activeTheme, 'shop') ?? 'store.shop';

        return view($view, [
            's' => $s,
            'products' => $products,
            'categories' => $categories,
            'collections' => $collections,
            'q' => $q,
            'cat' => $cat,
            'brand' => $brand,
            'min' => $minPrice,
            'max' => $maxPrice,
            'sort' => $sort,
            'collection' => $coll,
            'showCategoryBar' => true,
        ]);
    }

    /**
     * Product detail page — themed per the active store theme.
     */
    public function product(Request $request, string $slugOrId)
    {
        $s = StoreSetting::firstOrFail();

        $query = Product::query()
            ->where('is_active', 1)
            ->where('hide_from_online_store', 0)
            ->with(['variants', 'images' => fn ($q) => $q->orderBy('sort_order')->orderBy('id'), 'category', 'brand']);

        if (is_numeric($slugOrId)) {
            $product = $query->where('id', (int) $slugOrId)->first();
        } else {
            $hasSlug = Schema::hasColumn('products', 'slug');
            $product = $query->where(function ($q) use ($slugOrId, $hasSlug) {
                $q->where('code', $slugOrId)
                  ->orWhere('name', $slugOrId);
                if ($hasSlug) {
                    $q->orWhere('slug', $slugOrId);
                }
            })->first();
        }

        if (! $product) {
            abort(404);
        }

        $currency = $s->currency_code ?? '$';
        $hidePrices = ! Auth::guard('store')->check() && ($s->hide_prices_for_guests ?? false);

        $product->base_price = $product->variants->isNotEmpty()
            ? (float) $product->variants->min('price')
            : (float) $product->price;
        $product->display_price = $product->minDisplayPrice();
        foreach ($product->variants as $v) {
            $v->display_price = $product->computeFinalPrice(null, (float) ($v->price ?? 0))['final'];
        }
        $this->attachStockToProducts(collect([$product]), $s->default_warehouse_id);

        $related = Product::query()
            ->where('is_active', 1)
            ->where('hide_from_online_store', 0)
            ->where('id', '!=', $product->id)
            ->when($product->category_id, fn ($q) => $q->where('category_id', $product->category_id))
            ->with(['variants:id,product_id,name,price,image', 'images:id,product_id,image_path,is_main,sort_order'])
            ->latest()
            ->take(8)
            ->get();

        foreach ($related as $rp) {
            $rp->base_price = $rp->variants->isNotEmpty()
                ? (float) $rp->variants->min('price')
                : (float) $rp->price;
            $rp->display_price = $rp->minDisplayPrice();
        }
        $this->attachStockToProducts($related, $s->default_warehouse_id);

        $productVm = StorefrontPresenter::product($product, $currency, $hidePrices);
        $relatedVm = $related->map(fn ($rp) => StorefrontPresenter::product($rp, $currency, $hidePrices))->values()->all();

        $activeTheme = $this->resolveActiveTheme($request, $s);
        $view = StorefrontThemeRegistry::viewFor($activeTheme, 'product') ?? 'store.product';

        return view($view, [
            's' => $s,
            'p' => $product,
            'product' => $productVm,
            'related' => $relatedVm,
            'currency' => $currency,
            'categories' => $this->getThemedCategories($activeTheme),
            'showCategoryBar' => false,
        ]);
    }

    /**
     * Full-page cart — themed per the active store theme. Reuses the same
     * Alpine miniCart() component (client-side cart state) as the drawer,
     * just rendered full-page instead of inside a slide-out.
     */
    public function cart(Request $request)
    {
        $s = StoreSetting::firstOrFail();

        $activeTheme = $this->resolveActiveTheme($request, $s);
        $view = StorefrontThemeRegistry::viewFor($activeTheme, 'cart') ?? 'store.cart';

        return view($view, [
            's' => $s,
            'categories' => $this->getThemedCategories($activeTheme),
            'showCategoryBar' => false,
        ]);
    }

    public function contact()
    {
        $s = StoreSetting::first();

        return view('store.contact', compact('s'));
    }

    /**
     * Shared price-calculation SQL fragments used by both index() and shop()
     * (previously duplicated verbatim in each method).
     *
     * @return array{0: \Illuminate\Database\Query\Builder, 1: string, 2: string, 3: string}
     */
    private function priceSqlExpressions(): array
    {
        $minVariantSub = DB::table('product_variants')
            ->select('product_id', DB::raw('MIN(price) AS min_variant_price'))
            ->groupBy('product_id');

        // Base: if a product has variants, use MIN(variant.price); else use products.price
        $baseExpr = 'COALESCE(pvmin.min_variant_price, products.price)';

        // discount_method: '1' => percent, '2' => fixed
        $discValExpr = 'IFNULL(products.discount, 0)';
        $afterDiscountExpr = "GREATEST(0,
            CASE
                WHEN products.discount_method = '1' THEN $baseExpr - ($baseExpr * ($discValExpr/100))
                WHEN products.discount_method = '2' THEN $baseExpr - LEAST($discValExpr, $baseExpr)
                ELSE $baseExpr
            END
        )";

        // tax_method: '2' => Inclusive (leave as-is), otherwise treat as Exclusive and add tax
        $taxRateExpr = 'COALESCE(products.TaxNet, 0)';
        $finalExpr = "ROUND(
            CASE
                WHEN products.tax_method = '2' THEN $afterDiscountExpr
                ELSE $afterDiscountExpr * (1 + ($taxRateExpr/100))
            END, 2
        )";

        return [$minVariantSub, $baseExpr, $afterDiscountExpr, $finalExpr];
    }

    /**
     * Attach stock (qty) to each product and its variants from product_warehouse for the given warehouse.
     * Product without variants: $p->stock. Variants: $v->stock (fallback to $v->qty if no warehouse row).
     */
    private function attachStockToProducts($products, ?int $warehouseId): void
    {
        if (! $warehouseId || ! $products) {
            foreach ($products as $p) {
                $p->stock = 0;
                if ($p->relationLoaded('variants') && $p->variants) {
                    foreach ($p->variants as $v) {
                        $v->stock = (float) ($v->qty ?? 0);
                    }
                }
            }

            return;
        }

        $items = $products instanceof \Illuminate\Pagination\AbstractPaginator ? $products->items() : $products;
        $productIds = collect($items)->pluck('id')->unique()->filter()->values()->all();
        if (empty($productIds)) {
            return;
        }

        $variantIds = [];
        foreach ($items as $p) {
            if ($p->relationLoaded('variants') && $p->variants) {
                foreach ($p->variants as $v) {
                    $variantIds[] = $v->id;
                }
            }
        }
        $variantIds = array_values(array_unique(array_filter($variantIds)));

        $q = DB::table('product_warehouse')
            ->where('warehouse_id', $warehouseId)
            ->whereIn('product_id', $productIds);
        if (count($variantIds) > 0) {
            $q->where(function ($qb) use ($variantIds) {
                $qb->whereNull('product_variant_id')
                    ->orWhereIn('product_variant_id', $variantIds);
            });
        } else {
            $q->whereNull('product_variant_id');
        }
        $rows = $q->when(Schema::hasColumn('product_warehouse', 'deleted_at'), fn ($qb) => $qb->whereNull('deleted_at'))
            ->select('product_id', 'product_variant_id', 'qte')
            ->get();

        $stockMap = [];
        foreach ($rows as $r) {
            $pid = (int) $r->product_id;
            $vid = $r->product_variant_id !== null ? (int) $r->product_variant_id : null;
            $key = $vid !== null ? "{$pid}:{$vid}" : "{$pid}:p";
            $stockMap[$key] = (float) $r->qte;
        }

        foreach ($items as $p) {
            $pid = (int) $p->id;
            if ($p->relationLoaded('variants') && $p->variants && $p->variants->isNotEmpty()) {
                // For products with variants, prefer variant-level stock rows.
                // If your DB only tracks product-level stock (product_variant_id NULL), use that as a fallback for each variant.
                $p->stock = null;
                $productFallback = $stockMap["{$pid}:p"] ?? null;
                foreach ($p->variants as $v) {
                    $key = "{$pid}:" . (int) $v->id;
                    if (array_key_exists($key, $stockMap)) {
                        $v->stock = (float) $stockMap[$key];
                    } elseif ($productFallback !== null) {
                        $v->stock = (float) $productFallback;
                    } else {
                        // Legacy fallback if a `qty` column exists on variants
                        $v->stock = (float) ($v->qty ?? 0);
                    }
                }
            } else {
                $p->stock = $stockMap["{$pid}:p"] ?? 0;
            }
        }
    }

    /**
     * Whether the product has at least one unit in stock (after attachStockToProducts).
     */
    private function productHasStock($p): bool
    {
        // Pre-order products should always be considered "available"
        if ($p->is_preorder) {
            return true;
        }

        if ($p->relationLoaded('variants') && $p->variants && $p->variants->isNotEmpty()) {
            return $p->variants->contains(fn ($v) => (float) ($v->stock ?? 0) > 0);
        }

        return (float) ($p->stock ?? 0) > 0;
    }

    /**
     * Product IDs that have at least one unit in stock in the given warehouse.
     * Used when hide_out_of_stock is enabled.
     */
    private function getInStockProductIds(int $warehouseId): array
    {
        $q = DB::table('product_warehouse')
            ->where('warehouse_id', $warehouseId)
            ->where('qte', '>', 0);
        if (Schema::hasColumn('product_warehouse', 'deleted_at')) {
            $q->whereNull('deleted_at');
        }

        $inStockIds = $q->distinct()->pluck('product_id')->all();

        // Include pre-order products even when out of stock
        $preorderIds = DB::table('products')
            ->where('is_preorder', true)
            ->where('is_active', 1)
            ->whereNull('deleted_at')
            ->pluck('id')
            ->all();

        return array_values(array_unique(array_merge($inStockIds, $preorderIds)));
    }
    /**
     * Search suggestions for autocomplete.
     */
    public function searchSuggestions(Request $request)
    {
        $q = trim((string) $request->get('q', ''));
        if (strlen($q) < 2) {
            return response()->json([]);
        }

        $s = StoreSetting::first();
        $warehouseId = $s->default_warehouse_id ?? null;

        $products = Product::query()
            ->where('is_active', 1)
            ->where('hide_from_online_store', 0)
            ->where(function ($query) use ($q) {
                $query->where('name', 'like', "%{$q}%")
                    ->orWhere('code', 'like', "%{$q}%")
                    ->orWhere('note', 'like', "%{$q}%");
            })
            ->take(8)
            ->get(['id', 'name', 'code', 'image', 'price', 'tax_method', 'TaxNet', 'discount', 'discount_method']);

        foreach ($products as $p) {
            $p->loadMissing(['images' => fn ($q) => $q->orderBy('sort_order')->orderBy('id')]);
            $fn = $p->primaryProductImageFilename();
            $p->image_url = global_asset(upload_path('products').'/'.($fn ?: 'no-image.png'));
            $p->display_price = $p->computeFinalPrice()['final'];
            $p->url = route('store.shop', ['q' => $p->name]);
        }

        return response()->json($products);
    }

    /**
     * Get categories scoped by the active storefront theme.
     */
    protected function getThemedCategories(string $activeTheme)
    {
        // Category-specific themes (restrict_category_code in their theme.json)
        // are locked to exactly one category -- handled generically here so
        // every call site (home, shop, product, cart) gets the same single
        // category instead of each needing its own per-theme hardcoding like
        // the blocks below.
        $restrictedCode = StorefrontThemeRegistry::restrictedCategoryCode($activeTheme);
        if ($restrictedCode) {
            return Category::with('subcategories')->where('code', $restrictedCode)->get();
        }

        if ($activeTheme === 'generalhub' || $activeTheme === 'generalhub-store' || $activeTheme === 'generalhub-mega') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Electronics',
                    'Fashion',
                    'Home & Living',
                    'Beauty',
                    'Accessories',
                    'Sports',
                    'Toys & Games',
                    'Daily Essentials',
                ])
                ->orderByRaw("FIELD(name, 'Electronics', 'Fashion', 'Home & Living', 'Beauty', 'Accessories', 'Sports', 'Toys & Games', 'Daily Essentials')")
                ->get();
        }

        if ($activeTheme === 'aurumeclat' || $activeTheme === 'aurumeclat-jewelry') {
            return Category::with('subcategories')
                ->where(function ($q) {
                    $q->whereIn('name', ['Fine Jewelry', 'Jewelry'])
                      ->orWhere('code', 'like', 'CAT-IND-JWL%');
                })
                ->orderBy('name')
                ->get();
        }

        if ($activeTheme === 'voguelane-couture' || $activeTheme === 'voguelane' || $activeTheme === 'voguelane-fashion') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Women',
                    'Men',
                    'Shoes',
                    'Bags',
                    'Accessories',
                    'Beauty',
                    'Jewelry',
                ])
                ->orderByRaw("FIELD(name, 'Women', 'Men', 'Shoes', 'Bags', 'Accessories', 'Beauty', 'Jewelry')")
                ->get();
        }

        if ($activeTheme === 'paperloom') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Books',
                    'Fiction',
                    'Non-Fiction',
                    'Children',
                    'Academic',
                    'Stationery',
                    'Notebooks',
                    'Journals',
                    'Art Supplies',
                    'Desk Accessories',
                    'Gifts',
                ])
                ->orderByRaw("FIELD(name, 'Books', 'Fiction', 'Non-Fiction', 'Children', 'Academic', 'Stationery', 'Notebooks', 'Journals', 'Art Supplies', 'Desk Accessories', 'Gifts')")
                ->get();
        }

        if ($activeTheme === 'marketverse-deals' || $activeTheme === 'marketverse') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Fashion',
                    'Electronics',
                    'Home & Living',
                    'Beauty & Personal Care',
                    'Grocery & Essentials',
                    'Sports & Outdoors',
                    'Toys & Games',
                    'Automotive',
                    'Books & Stationery',
                    'Pet Supplies',
                ])
                ->orderByRaw("FIELD(name, 'Fashion', 'Electronics', 'Home & Living', 'Beauty & Personal Care', 'Grocery & Essentials', 'Sports & Outdoors', 'Toys & Games', 'Automotive', 'Books & Stationery', 'Pet Supplies')")
                ->get();
        }

        if ($activeTheme === 'veloura-beauty' || $activeTheme === 'veloura') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Fragrance',
                    'Skincare',
                    'Makeup',
                    'Bath & Body',
                    'Hair Care',
                    'Gift Sets',
                    "Men's Grooming",
                    'Clean Beauty',
                ])
                ->orderByRaw("FIELD(name, 'Fragrance', 'Skincare', 'Makeup', 'Bath & Body', 'Hair Care', 'Gift Sets', \"Men's Grooming\", 'Clean Beauty')")
                ->get();
        }

        if ($activeTheme === 'technova-audio' || $activeTheme === 'technova' || $activeTheme === 'technova-electronics') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Smartphones',
                    'Laptops',
                    'Tablets',
                    'Audio',
                    'Gaming',
                    'Cameras',
                    'Smart Home',
                    'Accessories',
                ])
                ->orderByRaw("FIELD(name, 'Smartphones', 'Laptops', 'Tablets', 'Audio', 'Gaming', 'Cameras', 'Smart Home', 'Accessories')")
                ->get();
        }

        if ($activeTheme === 'naturae-wellness' || $activeTheme === 'naturae') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Skincare',
                    'Hair Care',
                    'Bath & Body',
                    'Wellness',
                    'Home Care',
                    'Organic Tea',
                    'Gift Sets',
                    'Accessories',
                ])
                ->orderByRaw("FIELD(name, 'Skincare', 'Hair Care', 'Bath & Body', 'Wellness', 'Home Care', 'Organic Tea', 'Gift Sets', 'Accessories')")
                ->get();
        }

        if ($activeTheme === 'nexora-trending' || $activeTheme === 'nexora') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Electronics',
                    'Fashion',
                    'Home & Living',
                    'Beauty',
                    'Sports',
                    'Toys & Games',
                    'Automotive',
                    'Accessories',
                ])
                ->orderByRaw("FIELD(name, 'Electronics', 'Fashion', 'Home & Living', 'Beauty', 'Sports', 'Toys & Games', 'Automotive', 'Accessories')")
                ->get();
        }

        if ($activeTheme === 'urbanic') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'T-Shirts',
                    'Shirts',
                    'Dresses',
                    'Jeans',
                    'Jackets',
                    'Footwear',
                    'Bags',
                    'Watches',
                    'Sunglasses',
                    'Activewear',
                    'Women',
                    'Men',
                    'Kids',
                    'Shoes',
                    'Accessories',
                    'Fashion',
                ])
                ->orderByRaw("FIELD(name, 'T-Shirts', 'Shirts', 'Dresses', 'Jeans', 'Jackets', 'Footwear', 'Bags', 'Watches', 'Sunglasses', 'Activewear', 'Women', 'Men', 'Kids', 'Shoes', 'Accessories', 'Fashion')")
                ->get();
        }

        if ($activeTheme === 'homely') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Home & Living',
                    'Living Room',
                    'Kitchen & Dining',
                    'Bedroom',
                    'Bathroom',
                    'Indoor Plants',
                    'Plants',
                    'Decor',
                    'Furniture',
                    'Bath & Body',
                    'Lighting',
                    'Textiles',
                    'Storage',
                ])
                ->orderByRaw("FIELD(name, 'Home & Living', 'Living Room', 'Kitchen & Dining', 'Bedroom', 'Bathroom', 'Indoor Plants', 'Plants', 'Decor', 'Furniture', 'Bath & Body', 'Lighting', 'Textiles', 'Storage')")
                ->get();
        }

        if ($activeTheme === 'verde' || $activeTheme === 'verde-living') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Home & Decor',
                    'Cleaning Essentials',
                    'Bath & Body',
                    'Kitchen & Dining',
                    'Gifts & Sets',
                    'Beauty',
                    'Journal',
                    'Decor',
                    'Kitchen',
                    'Bath',
                ])
                ->orderByRaw("FIELD(name, 'Home & Decor', 'Cleaning Essentials', 'Bath & Body', 'Kitchen & Dining', 'Gifts & Sets', 'Beauty', 'Journal', 'Decor', 'Kitchen', 'Bath')")
                ->get();
        }

        if ($activeTheme === 'zanova-flash' || $activeTheme === 'zanova' || $activeTheme === 'zanova-marketplace') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Electronics',
                    'Fashion & Apparel',
                    'Home & Kitchen',
                    'Beauty & Personal Care',
                    'Toys & Games',
                    'Sports & Outdoors',
                    'Automotive',
                    'Books & Stationery',
                    'Pet Supplies',
                    'Groceries & Essentials',
                    'Health & Wellness',
                    'Gift Ideas'
                ])
                ->orderByRaw("FIELD(name, 'Electronics', 'Fashion & Apparel', 'Home & Kitchen', 'Beauty & Personal Care', 'Toys & Games', 'Sports & Outdoors', 'Automotive', 'Books & Stationery', 'Pet Supplies', 'Groceries & Essentials', 'Health & Wellness', 'Gift Ideas')")
                ->get();
        }

        if ($activeTheme === 'novatech-electronics' || $activeTheme === 'novatech' || $activeTheme === 'novatech-tech') {
            return Category::with('subcategories')
                ->whereIn('name', [
                    'Laptops',
                    'Smartphones',
                    'Wearables',
                    'Audio',
                    'Gaming',
                    'Accessories',
                    'Cameras',
                    'Smart Home',
                    'Software',
                    'Home Appliances',
                    'Electronics'
                ])
                ->orderByRaw("FIELD(name, 'Laptops', 'Smartphones', 'Wearables', 'Audio', 'Gaming', 'Accessories', 'Cameras', 'Smart Home', 'Software', 'Home Appliances', 'Electronics')")
                ->get();
        }

        return Category::with('subcategories')->orderBy('name')->get();
    }
}
