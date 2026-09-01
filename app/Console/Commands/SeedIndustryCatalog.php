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
 * something real and on-brand to show instead of "no-image.png". Also
 * backfills the pre-existing generic DemoDataSeeder's 4 brands and 8
 * products, which hardcode that same placeholder filename.
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

        // catalogDefinition() must stay first and untouched, in its existing
        // order -- product codes are assigned sequentially, so anything
        // seeded before today (PR-IND-001..042) has to keep landing on the
        // same code. New products only ever get appended via
        // moreProductsDefinition(), never inserted into catalogDefinition().
        $seq = 1;
        foreach (array_merge($this->catalogDefinition(), $this->moreProductsDefinition()) as $industry) {
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

            foreach ($industry['products'] as [$name, $query, $price, $description]) {
                $code = self::CODE_PREFIX . str_pad((string) $seq, 3, '0', STR_PAD_LEFT);
                $seq++;

                $existingId = DB::table('products')->where('code', $code)->value('id');
                if ($existingId && ! $this->option('force')) {
                    // Already seeded (photo included) on a previous run -- just
                    // backfill the description if this command's product list
                    // has since gained one, without spending another API call.
                    DB::table('products')->where('id', $existingId)->update([
                        'note' => $description,
                        'updated_at' => $now,
                    ]);
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
                        'note' => $description,
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

        $this->backfillLegacyDemoImages($accessKey, $dir);

        return self::SUCCESS;
    }

    /**
     * The pre-existing generic DemoDataSeeder (unrelated to this command)
     * seeds 4 brands and 8 products with a hardcoded 'no-image.png'
     * placeholder filename -- never a real photo. Backfill those with real
     * Unsplash photos too, the same way, so nothing in the demo storefront
     * is left showing a broken/placeholder image.
     */
    private function backfillLegacyDemoImages(string $accessKey, string $dir): void
    {
        $now = Carbon::now();

        $brands = [
            'AquaPure' => 'water bottle brand',
            'CrunchCo' => 'snack food brand',
            'TechNova' => 'technology electronics brand',
            'WriteWell' => 'pen notebook stationery brand',
        ];

        $products = [
            'PR-DEMO-001' => ['Mineral Water 500ml', 'mineral water bottle'],
            'PR-DEMO-002' => ['Cola Can 330ml', 'soda can drink'],
            'PR-DEMO-003' => ['Potato Chips 100g', 'potato chips snack'],
            'PR-DEMO-004' => ['Chocolate Bar 50g', 'chocolate bar'],
            'PR-DEMO-005' => ['USB-C Cable 1m', 'usb c cable'],
            'PR-DEMO-006' => ['Wireless Mouse', 'wireless computer mouse'],
            'PR-DEMO-007' => ['Notebook A5', 'notebook paper'],
            'PR-DEMO-008' => ['Ballpoint Pen', 'ballpoint pen'],
        ];

        $didWork = false;

        foreach ($brands as $name => $query) {
            $row = DB::table('brands')->where('name', $name)->first();
            if (! $row || $row->image !== 'no-image.png') {
                continue;
            }

            $didWork = true;
            $filename = $this->downloadUnsplashPhoto($accessKey, $query, $dir, Str::slug($name));
            if (! $filename) {
                $this->warn("  \xE2\x9C\x97 {$name} (brand) — could not fetch a photo for \"{$query}\", skipped.");
                continue;
            }

            DB::table('brands')->where('id', $row->id)->update(['image' => $filename, 'updated_at' => $now]);
            $this->line("  \xE2\x9C\x93 {$name} (brand)");
        }

        foreach ($products as $code => [$name, $query]) {
            $row = DB::table('products')->where('code', $code)->first();
            if (! $row || $row->image !== 'no-image.png') {
                continue;
            }

            $didWork = true;
            $filename = $this->downloadUnsplashPhoto($accessKey, $query, $dir, Str::slug($name));
            if (! $filename) {
                $this->warn("  \xE2\x9C\x97 {$name} — could not fetch a photo for \"{$query}\", skipped.");
                continue;
            }

            DB::table('products')->where('id', $row->id)->update(['image' => $filename, 'updated_at' => $now]);
            $this->line("  \xE2\x9C\x93 {$name}");
        }

        if ($didWork) {
            $this->info('Legacy demo images backfilled.');
        }
    }

    /**
     * Fetch the top Unsplash search result for $query and save it locally.
     * Only the Search API call counts against Unsplash's rate limit (50/hr
     * on a free "Demo" app) — the CDN image download itself does not — so
     * this stays well under that limit even for the full ~42-product catalog.
     */
    private function downloadUnsplashPhoto(string $accessKey, string $query, string $dir, string $slug): ?string
    {
        // Try the constrained search first (squarish, high content filter);
        // some specific queries have too few matches under those constraints,
        // so fall back to a plain search before giving up on the query.
        $photo = $this->searchUnsplash($accessKey, $query, ['orientation' => 'squarish', 'content_filter' => 'high'])
            ?? $this->searchUnsplash($accessKey, $query, []);

        if (! $photo) {
            return null;
        }

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
     * @param array<string, string> $extraParams
     * @return array<string, mixed>|null
     */
    private function searchUnsplash(string $accessKey, string $query, array $extraParams): ?array
    {
        $search = Http::withHeaders(['Authorization' => "Client-ID {$accessKey}"])
            ->get('https://api.unsplash.com/search/photos', array_merge([
                'query' => $query,
                'per_page' => 1,
            ], $extraParams));

        if (! $search->ok()) {
            $this->warn("    Unsplash search request failed ({$search->status()}): " . $search->body());

            return null;
        }

        return $search->json('results.0');
    }

    /**
     * @return array<int, array{code:string, category:string, products:array<int, array{0:string,1:string,2:float,3:string}>}>
     */
    private function catalogDefinition(): array
    {
        return [
            ['code' => 'CAT-IND-JWL', 'category' => 'Jewelry & Watches', 'products' => [
                ['Gold Diamond Ring', 'gold diamond ring jewelry', 249.00, '18k gold band set with a brilliant-cut diamond centerpiece, hand-finished and hallmarked.'],
                ['Silver Pendant Necklace', 'silver necklace pendant jewelry', 89.00, 'Sterling silver pendant on an 18-inch chain, finished with a tarnish-resistant coating.'],
                ['Luxury Wristwatch', 'luxury wristwatch', 399.00, 'Automatic movement watch with a sapphire crystal face and genuine leather strap.'],
            ]],
            ['code' => 'CAT-IND-FSH', 'category' => 'Fashion & Apparel', 'products' => [
                ['Leather Biker Jacket', 'leather jacket fashion', 129.00, 'Genuine leather biker jacket with asymmetric zip and quilted shoulder panels.'],
                ['Designer Sneakers', 'designer sneakers shoes', 89.00, 'Lightweight knit-upper sneakers with a cushioned midsole for all-day wear.'],
                ['Summer Floral Dress', 'summer dress fashion', 59.00, 'Breathable floral-print midi dress with an adjustable waist tie.'],
            ]],
            ['code' => 'CAT-IND-BTY', 'category' => 'Beauty & Cosmetics', 'products' => [
                ['Radiance Skincare Serum', 'skincare serum bottle cosmetics', 34.00, 'Vitamin C serum formulated to brighten skin tone and even texture over time.'],
                ['Matte Liquid Lipstick', 'matte lipstick cosmetics', 18.00, 'Long-wear matte lipstick that resists transfer without drying out lips.'],
                ['Pro Makeup Brush Set', 'makeup brush set cosmetics', 42.00, '12-piece synthetic-bristle brush set covering face, eyes, and contour.'],
            ]],
            ['code' => 'CAT-IND-ELC', 'category' => 'Electronics & Gadgets', 'products' => [
                ['Wireless Noise-Cancelling Headphones', 'wireless headphones electronics', 129.00, 'Over-ear Bluetooth headphones with active noise cancellation and 30-hour battery life.'],
                ['Smartwatch Series X', 'smartwatch electronics', 199.00, 'Fitness-tracking smartwatch with heart-rate monitoring and a 5-day battery.'],
                ['4K Camera Drone', 'drone electronics gadget', 349.00, 'Folding quadcopter drone with a stabilized 4K camera and 25-minute flight time.'],
            ]],
            ['code' => 'CAT-IND-GRC', 'category' => 'Grocery & Fresh Produce', 'products' => [
                ['Fresh Vegetable Basket', 'fresh vegetables basket grocery', 12.50, 'Hand-picked seasonal vegetable assortment, sourced from local growers.'],
                ['Organic Fruit Box', 'organic fruits grocery', 15.00, 'Certified-organic mixed fruit box, packed fresh for same-week delivery.'],
                ['Artisan Sourdough Bread', 'artisan bread bakery', 6.50, 'Naturally leavened sourdough loaf, baked fresh daily in small batches.'],
            ]],
            ['code' => 'CAT-IND-FIT', 'category' => 'Fitness & Gym', 'products' => [
                ['Adjustable Dumbbell Set', 'dumbbell set gym fitness', 89.00, 'Space-saving dumbbell pair with quick-adjust weight plates from 5 to 25 lbs.'],
                ['Premium Yoga Mat', 'yoga mat fitness', 29.00, 'Non-slip 6mm yoga mat with dual-sided grip texture and carry strap.'],
                ['Whey Protein Powder', 'protein powder fitness supplement', 39.00, '24g of whey protein per serving, low sugar, mixes smoothly with no clumping.'],
            ]],
            ['code' => 'CAT-IND-BKS', 'category' => 'Books & Stationery', 'products' => [
                ['Bestseller Book Bundle', 'stack of books', 24.00, 'Curated bundle of three current bestselling paperbacks across fiction and non-fiction.'],
                ['Leather Journal Notebook', 'leather journal notebook stationery', 19.00, 'Refillable leather-bound journal with 200 pages of acid-free paper.'],
                ['Fountain Pen Set', 'fountain pen stationery', 22.00, 'Smooth-writing fountain pen with a fine nib, gift-boxed with two ink cartridges.'],
            ]],
            ['code' => 'CAT-IND-RST', 'category' => 'Restaurant & Food Delivery', 'products' => [
                ['Gourmet Wood-Fired Pizza', 'gourmet pizza food', 14.00, 'Wood-fired thin-crust pizza topped with fresh mozzarella and basil.'],
                ['Signature Beef Burger', 'burger food plate', 9.50, 'Char-grilled beef patty with aged cheddar, house sauce, and a brioche bun.'],
                ['Fresh Garden Salad Bowl', 'fresh salad bowl food', 8.00, 'Crisp mixed greens with cherry tomatoes, cucumber, and a light vinaigrette.'],
            ]],
            ['code' => 'CAT-IND-MKT', 'category' => 'Marketplace & General Retail', 'products' => [
                ['Everyday Essentials Bundle', 'shopping bags retail', 19.99, 'A hand-picked bundle of everyday household essentials at one flat price.'],
                ['Premium Gift Box Set', 'gift box retail', 29.99, 'Ready-to-give gift box with premium wrapping and a personalized note card.'],
                ['Home Care Value Pack', 'home essentials retail products', 24.99, 'Multi-pack of home care basics, sized for a full month of everyday use.'],
            ]],
            ['code' => 'CAT-IND-PET', 'category' => 'Pet Supplies & Accessories', 'products' => [
                ['Comfort Dog Leash & Collar Set', 'dog leash collar pet', 22.00, 'Padded nylon leash and collar set with reflective stitching for night walks.'],
                ['Interactive Cat Toy', 'cat toy pet', 12.00, 'Motion-activated toy that keeps cats engaged with unpredictable movement.'],
                ['Ceramic Pet Food Bowl', 'dog bowl', 14.00, 'Heavyweight ceramic bowl that resists tipping and is dishwasher safe.'],
            ]],
            ['code' => 'CAT-IND-WHS', 'category' => 'Wholesale & B2B', 'products' => [
                ['Bulk Shipping Pallet', 'warehouse pallets wholesale', 199.00, 'Standard 48x40 shipping pallet rated for up to 2,800 lbs of static load.'],
                ['Cardboard Box Bundle (50pk)', 'cardboard boxes warehouse', 79.00, '50-pack of double-wall corrugated boxes for shipping and bulk storage.'],
                ['Warehouse Storage Rack', 'warehouse storage shelving', 249.00, '5-tier boltless steel shelving unit rated for 350 lbs per shelf.'],
            ]],
            ['code' => 'CAT-IND-AUT', 'category' => 'Auto Parts & Hardware', 'products' => [
                ['Performance Engine Part', 'car engine parts', 149.00, 'OEM-spec replacement engine component, tested to manufacturer tolerances.'],
                ['Professional Wrench Tool Set', 'wrench tool set hardware', 59.00, '32-piece chrome vanadium wrench and socket set with a carrying case.'],
                ['All-Season Car Tire', 'car tire auto', 89.00, 'All-season radial tire engineered for wet and dry traction year-round.'],
            ]],
            ['code' => 'CAT-IND-DIG', 'category' => 'Digital Products & Software', 'products' => [
                ['Pro Design Software License', 'laptop software code', 59.00, 'One-year license for professional design software, single-seat activation.'],
                ['UI/UX Template Pack', 'ui ux design software', 39.00, 'Editable UI/UX template pack covering 40+ common app screen layouts.'],
                ['Cloud Backup Subscription', 'cloud computing server', 9.99, '1TB of encrypted cloud backup storage, billed monthly, cancel anytime.'],
            ]],
            ['code' => 'CAT-IND-PHM', 'category' => 'Pharmacy & Medical', 'products' => [
                ['Daily Multivitamin Bottle', 'medicine bottle pills pharmacy', 15.00, '90-day supply of daily multivitamins covering essential vitamins and minerals.'],
                ['Digital Stethoscope', 'stethoscope medical', 45.00, 'Dual-head stethoscope with enhanced acoustic sensitivity for clinical use.'],
                ['Complete First Aid Kit', 'first aid kit medical', 24.00, '100-piece first aid kit stocked for home, travel, and workplace emergencies.'],
            ]],
        ];
    }

    /**
     * A second, later-appended batch -- two more products per industry.
     * Kept separate from catalogDefinition() (see the note in handle())
     * purely so the codes already assigned to that first batch never shift.
     *
     * @return array<int, array{code:string, category:string, products:array<int, array{0:string,1:string,2:float,3:string}>}>
     */
    private function moreProductsDefinition(): array
    {
        return [
            ['code' => 'CAT-IND-JWL', 'category' => 'Jewelry & Watches', 'products' => [
                ['Rose Gold Bracelet', 'gold bracelet jewelry', 179.00, '14k rose gold chain bracelet with a secure lobster-claw clasp.'],
                ['Diamond Stud Earrings', 'diamond earrings jewelry', 219.00, 'Classic round-cut diamond studs set in white gold, sold as a pair.'],
            ]],
            ['code' => 'CAT-IND-FSH', 'category' => 'Fashion & Apparel', 'products' => [
                ['Classic Denim Jeans', 'denim jeans fashion', 69.00, 'Straight-fit denim jeans in a mid-wash, built from durable stretch cotton.'],
                ['Wool Winter Coat', 'winter coat fashion', 159.00, 'Wool-blend overcoat with a notch lapel and quilted inner lining for warmth.'],
            ]],
            ['code' => 'CAT-IND-BTY', 'category' => 'Beauty & Cosmetics', 'products' => [
                ['Hydrating Face Cream', 'face cream cosmetics', 28.00, 'Lightweight daily moisturizer with hyaluronic acid for all skin types.'],
                ['Signature Perfume', 'perfume bottle', 65.00, 'Eau de parfum with warm amber and citrus notes, 50ml bottle.'],
            ]],
            ['code' => 'CAT-IND-ELC', 'category' => 'Electronics & Gadgets', 'products' => [
                ['Mechanical Gaming Keyboard', 'gaming keyboard electronics', 89.00, 'RGB-backlit mechanical keyboard with hot-swappable tactile switches.'],
                ['Portable Bluetooth Speaker', 'bluetooth speaker electronics', 59.00, 'Water-resistant Bluetooth speaker with 12 hours of playback per charge.'],
            ]],
            ['code' => 'CAT-IND-GRC', 'category' => 'Grocery & Fresh Produce', 'products' => [
                ['Farm Fresh Eggs (Dozen)', 'eggs carton grocery', 4.50, 'Free-range eggs from local farms, delivered within days of collection.'],
                ['Dairy Milk Bottle', 'milk bottle dairy', 3.20, 'Whole milk in a returnable glass bottle, pasteurized and locally sourced.'],
            ]],
            ['code' => 'CAT-IND-FIT', 'category' => 'Fitness & Gym', 'products' => [
                ['Resistance Band Set', 'resistance bands fitness', 24.00, 'Five-band resistance set covering light to heavy tension for full-body training.'],
                ['Foam Massage Roller', 'foam roller fitness', 27.00, 'High-density foam roller for post-workout muscle recovery and mobility work.'],
            ]],
            ['code' => 'CAT-IND-BKS', 'category' => 'Books & Stationery', 'products' => [
                ['Watercolor Art Set', 'watercolor paint set art', 32.00, '24-color watercolor set with brushes and a mixing palette included.'],
                ['Wooden Desk Organizer', 'desk organizer stationery', 26.00, 'Solid wood desk organizer with compartments for pens, cards, and notes.'],
            ]],
            ['code' => 'CAT-IND-RST', 'category' => 'Restaurant & Food Delivery', 'products' => [
                ['Fresh Sushi Platter', 'sushi platter food', 18.00, 'Chef-prepared sushi platter with a rotating selection of nigiri and rolls.'],
                ['Iced Coffee', 'iced coffee drink', 5.50, 'Cold-brewed iced coffee, brewed slow for a smooth, low-acidity finish.'],
            ]],
            ['code' => 'CAT-IND-MKT', 'category' => 'Marketplace & General Retail', 'products' => [
                ['Scented Candle Set', 'scented candle retail', 22.00, 'Set of three soy-wax candles in warm, seasonal fragrances.'],
                ['Kitchen Utensil Set', 'kitchen utensils retail', 34.00, '10-piece silicone kitchen utensil set with a heat-resistant holder.'],
            ]],
            ['code' => 'CAT-IND-PET', 'category' => 'Pet Supplies & Accessories', 'products' => [
                ['Cozy Pet Bed', 'pet bed dog', 39.00, 'Machine-washable orthopedic pet bed with a raised, cushioned rim.'],
                ['Aquarium Fish Tank', 'aquarium fish tank', 79.00, '20-gallon glass aquarium kit with filter and LED hood included.'],
            ]],
            ['code' => 'CAT-IND-WHS', 'category' => 'Wholesale & B2B', 'products' => [
                ['Industrial Shelving Unit', 'industrial shelving warehouse', 289.00, 'Heavy-gauge steel shelving unit rated for up to 800 lbs per shelf.'],
                ['Bulk Packaging Tape (24pk)', 'packaging tape warehouse', 49.00, '24-roll case of heavy-duty packing tape for high-volume shipping.'],
            ]],
            ['code' => 'CAT-IND-AUT', 'category' => 'Auto Parts & Hardware', 'products' => [
                ['Heavy-Duty Car Battery', 'car battery auto', 129.00, 'Maintenance-free 12V battery with high cold-cranking amps for reliable starts.'],
                ['Hydraulic Floor Jack', 'hydraulic car jack', 99.00, 'Low-profile 2-ton hydraulic floor jack with a fast-lift mechanism.'],
            ]],
            ['code' => 'CAT-IND-DIG', 'category' => 'Digital Products & Software', 'products' => [
                ['Stock Photo Bundle License', 'photography camera laptop', 49.00, 'Commercial-use license for a 500-image stock photography bundle.'],
                ['Online Course Bundle', 'online course laptop study', 29.00, 'Self-paced video course bundle with lifetime access and a completion certificate.'],
            ]],
            ['code' => 'CAT-IND-PHM', 'category' => 'Pharmacy & Medical', 'products' => [
                ['Blood Pressure Monitor', 'blood pressure monitor medical', 39.00, 'Automatic upper-arm blood pressure monitor with irregular-heartbeat detection.'],
                ['Hand Sanitizer Pack', 'hand sanitizer', 8.00, '3-pack of 70% alcohol hand sanitizer gel in travel-sized bottles.'],
            ]],
            ['code' => 'CAT-IND-OUT', 'category' => 'Outdoor & Adventure Gear', 'products' => [
                ['Trail Backpack 65L', 'hiking backpack outdoor gear', 259.95, 'Weatherproof 65-liter trekking backpack with an adjustable suspension frame for multi-day trails.'],
                ['Waterproof Hiking Boots', 'hiking boots outdoor', 149.95, 'Grippy, waterproof hiking boots built for rocky, wet trail conditions.'],
                ['GPS Adventure Watch', 'outdoor sports watch gps', 899.99, 'Rugged solar GPS watch with trail mapping and multi-day battery life.'],
                ['3-Person Camping Tent', 'camping tent outdoor', 449.95, 'Freestanding 3-person tent with a full-coverage rainfly for three-season camping.'],
                ['Insulated Steel Water Bottle', 'insulated water bottle outdoor', 44.99, 'Double-wall insulated steel bottle that keeps drinks cold for 24 hours on the trail.'],
                ['Rechargeable LED Headlamp', 'led headlamp camping', 59.95, 'Rechargeable headlamp with adjustable beam for night hikes and campsite chores.'],
            ]],
        ];
    }
}
