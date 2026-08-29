<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

/**
 * Seeds a realistic multi-industry product catalog — one category per
 * storefront theme industry (jewelry, fashion, beauty, electronics,
 * grocery, fitness, books, restaurant, marketplace, pets, wholesale,
 * auto parts, digital products, pharmacy) — with real photos fetched
 * live from the Unsplash Search API, so every theme's product grid has
 * something real and on-brand to show instead of "no-image.png".
 *
 * Run per-tenant, e.g.:
 *   php artisan tenants:run "demo:industry-catalog" --tenants=<tenant-id>
 *
 * Requires a free Unsplash "Demo" app access key in .env:
 *   UNSPLASH_ACCESS_KEY=your_key_here
 * (https://unsplash.com/oauth/applications — takes about two minutes.)
 */
class SeedIndustryCatalog extends Command
{
    protected $signature = 'demo:industry-catalog {--force : Re-download images and re-insert even if already seeded}';

    protected $description = 'Seed a multi-industry product catalog with real Unsplash photos, matching the 20 storefront themes.';

    private const WAREHOUSE_ID = 1;

    private const CODE_PREFIX = 'PR-IND-';

    public function handle(): int
    {
        $accessKey = config('services.unsplash.access_key');
        if (! $accessKey) {
            $this->error('UNSPLASH_ACCESS_KEY is not set in your .env file.');
            $this->line('Get a free key at https://unsplash.com/oauth/applications, add it as UNSPLASH_ACCESS_KEY=... in .env, then re-run this command.');

            return self::FAILURE;
        }

        // No blanket "already seeded" short-circuit here: each product below is
        // checked (and skipped, without spending an API call) individually, so
        // re-running this command after a partial failure correctly resumes
        // by only fetching whatever is still missing. --force re-fetches everything.

        $dir = upload_public_path('products');
        if (! is_dir($dir)) {
            mkdir($dir, 0755, true);
        }

        $now = Carbon::now();

        $unitId = DB::table('units')->value('id');
        if (! $unitId) {
            $unitId = DB::table('units')->insertGetId([
                'name' => 'Piece', 'ShortName' => 'pc', 'operator' => '*', 'operator_value' => 1,
                'created_at' => $now, 'updated_at' => $now,
            ]);
        }

        $seq = 1;
        foreach ($this->catalogDefinition() as $industry) {
            $categoryId = DB::table('categories')->where('code', $industry['code'])->value('id');
            if (! $categoryId) {
                $categoryId = DB::table('categories')->insertGetId([
                    'code' => $industry['code'],
                    'name' => $industry['category'],
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }

            $this->info($industry['category']);

            foreach ($industry['products'] as [$name, $query, $price]) {
                $code = self::CODE_PREFIX . str_pad((string) $seq, 3, '0', STR_PAD_LEFT);
                $seq++;

                $exists = DB::table('products')->where('code', $code)->exists();
                if ($exists && ! $this->option('force')) {
                    continue;
                }

                $filename = $this->downloadUnsplashPhoto($accessKey, $query, $dir, Str::slug($name));
                if (! $filename) {
                    $this->warn("  \xE2\x9C\x97 {$name} — could not fetch a photo for \"{$query}\", skipped.");
                    continue;
                }

                $cost = round($price * 0.55, 2);

                DB::table('products')->updateOrInsert(
                    ['code' => $code],
                    [
                        'type' => 'is_single',
                        'Type_barcode' => 'CODE128',
                        'name' => $name,
                        'image' => $filename,
                        'cost' => $cost,
                        'price' => $price,
                        'wholesale_price' => round($price * 0.9, 2),
                        'min_price' => round($price * 0.8, 2),
                        'points' => 0,
                        'category_id' => $categoryId,
                        'unit_id' => $unitId,
                        'unit_sale_id' => $unitId,
                        'unit_purchase_id' => $unitId,
                        'TaxNet' => 0,
                        'tax_method' => '1',
                        'stock_alert' => 5,
                        'is_active' => true,
                        'created_at' => $now,
                        'updated_at' => $now,
                    ]
                );

                $productId = DB::table('products')->where('code', $code)->value('id');

                DB::table('product_warehouse')->updateOrInsert(
                    ['product_id' => $productId, 'warehouse_id' => self::WAREHOUSE_ID],
                    ['qte' => 50, 'manage_stock' => true, 'created_at' => $now, 'updated_at' => $now]
                );

                $this->line("  \xE2\x9C\x93 {$name}");
            }
        }

        $this->info('Industry catalog seeded.');

        return self::SUCCESS;
    }

    /**
     * Fetch the top Unsplash search result for $query and save it locally.
     * Only the Search API call counts against Unsplash's rate limit (50/hr
     * on a free "Demo" app) — the CDN image download itself does not — so
     * this stays well under that limit even for the full ~42-product catalog.
     */
    private function downloadUnsplashPhoto(string $accessKey, string $query, string $dir, string $slug): ?string
    {
        $search = Http::withHeaders(['Authorization' => "Client-ID {$accessKey}"])
            ->get('https://api.unsplash.com/search/photos', [
                'query' => $query,
                'per_page' => 1,
                'orientation' => 'squarish',
                'content_filter' => 'high',
            ]);

        if (! $search->ok()) {
            return null;
        }

        $photo = $search->json('results.0');
        $imageUrl = $photo['urls']['regular'] ?? $photo['urls']['small'] ?? null;
        if (! $imageUrl) {
            return null;
        }

        $image = Http::get($imageUrl);
        if (! $image->ok()) {
            return null;
        }

        $filename = $slug . '-' . Str::random(6) . '.jpg';
        file_put_contents($dir . '/' . $filename, $image->body());

        return $filename;
    }

    /**
     * @return array<int, array{code:string, category:string, products:array<int, array{0:string,1:string,2:float}>}>
     */
    private function catalogDefinition(): array
    {
        return [
            ['code' => 'CAT-IND-JWL', 'category' => 'Jewelry & Watches', 'products' => [
                ['Gold Diamond Ring', 'gold diamond ring jewelry', 249.00],
                ['Silver Pendant Necklace', 'silver necklace pendant jewelry', 89.00],
                ['Luxury Wristwatch', 'luxury wristwatch', 399.00],
            ]],
            ['code' => 'CAT-IND-FSH', 'category' => 'Fashion & Apparel', 'products' => [
                ['Leather Biker Jacket', 'leather jacket fashion', 129.00],
                ['Designer Sneakers', 'designer sneakers shoes', 89.00],
                ['Summer Floral Dress', 'summer dress fashion', 59.00],
            ]],
            ['code' => 'CAT-IND-BTY', 'category' => 'Beauty & Cosmetics', 'products' => [
                ['Radiance Skincare Serum', 'skincare serum bottle cosmetics', 34.00],
                ['Matte Liquid Lipstick', 'matte lipstick cosmetics', 18.00],
                ['Pro Makeup Brush Set', 'makeup brush set cosmetics', 42.00],
            ]],
            ['code' => 'CAT-IND-ELC', 'category' => 'Electronics & Gadgets', 'products' => [
                ['Wireless Noise-Cancelling Headphones', 'wireless headphones electronics', 129.00],
                ['Smartwatch Series X', 'smartwatch electronics', 199.00],
                ['4K Camera Drone', 'drone electronics gadget', 349.00],
            ]],
            ['code' => 'CAT-IND-GRC', 'category' => 'Grocery & Fresh Produce', 'products' => [
                ['Fresh Vegetable Basket', 'fresh vegetables basket grocery', 12.50],
                ['Organic Fruit Box', 'organic fruits grocery', 15.00],
                ['Artisan Sourdough Bread', 'artisan bread bakery', 6.50],
            ]],
            ['code' => 'CAT-IND-FIT', 'category' => 'Fitness & Gym', 'products' => [
                ['Adjustable Dumbbell Set', 'dumbbell set gym fitness', 89.00],
                ['Premium Yoga Mat', 'yoga mat fitness', 29.00],
                ['Whey Protein Powder', 'protein powder fitness supplement', 39.00],
            ]],
            ['code' => 'CAT-IND-BKS', 'category' => 'Books & Stationery', 'products' => [
                ['Bestseller Book Bundle', 'stack of books', 24.00],
                ['Leather Journal Notebook', 'leather journal notebook stationery', 19.00],
                ['Fountain Pen Set', 'fountain pen stationery', 22.00],
            ]],
            ['code' => 'CAT-IND-RST', 'category' => 'Restaurant & Food Delivery', 'products' => [
                ['Gourmet Wood-Fired Pizza', 'gourmet pizza food', 14.00],
                ['Signature Beef Burger', 'burger food plate', 9.50],
                ['Fresh Garden Salad Bowl', 'fresh salad bowl food', 8.00],
            ]],
            ['code' => 'CAT-IND-MKT', 'category' => 'Marketplace & General Retail', 'products' => [
                ['Everyday Essentials Bundle', 'shopping bags retail', 19.99],
                ['Premium Gift Box Set', 'gift box retail', 29.99],
                ['Home Care Value Pack', 'home essentials retail products', 24.99],
            ]],
            ['code' => 'CAT-IND-PET', 'category' => 'Pet Supplies & Accessories', 'products' => [
                ['Comfort Dog Leash & Collar Set', 'dog leash collar pet', 22.00],
                ['Interactive Cat Toy', 'cat toy pet', 12.00],
                ['Ceramic Pet Food Bowl', 'dog bowl', 14.00],
            ]],
            ['code' => 'CAT-IND-WHS', 'category' => 'Wholesale & B2B', 'products' => [
                ['Bulk Shipping Pallet', 'warehouse pallets wholesale', 199.00],
                ['Cardboard Box Bundle (50pk)', 'cardboard boxes warehouse', 79.00],
                ['Warehouse Storage Rack', 'warehouse storage shelving', 249.00],
            ]],
            ['code' => 'CAT-IND-AUT', 'category' => 'Auto Parts & Hardware', 'products' => [
                ['Performance Engine Part', 'car engine parts', 149.00],
                ['Professional Wrench Tool Set', 'wrench tool set hardware', 59.00],
                ['All-Season Car Tire', 'car tire auto', 89.00],
            ]],
            ['code' => 'CAT-IND-DIG', 'category' => 'Digital Products & Software', 'products' => [
                ['Pro Design Software License', 'laptop software code', 59.00],
                ['UI/UX Template Pack', 'ui ux design software', 39.00],
                ['Cloud Backup Subscription', 'cloud computing server', 9.99],
            ]],
            ['code' => 'CAT-IND-PHM', 'category' => 'Pharmacy & Medical', 'products' => [
                ['Daily Multivitamin Bottle', 'medicine bottle pills pharmacy', 15.00],
                ['Digital Stethoscope', 'stethoscope medical', 45.00],
                ['Complete First Aid Kit', 'first aid kit medical', 24.00],
            ]],
        ];
    }
}
