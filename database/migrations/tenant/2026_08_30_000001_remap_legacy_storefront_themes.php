<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * The 10 old System A (industry Blade layout) slugs and 10 old System B
 * (color-token-only) slugs are being retired in favor of 20 new unified
 * general-merchandise themes. Remap any tenant still pointing at an old
 * slug to a reasonable new-theme default so `store_settings.theme` never
 * holds a dangling value once the old theme folders are deleted.
 *
 * Belt-and-suspenders: StorefrontThemeRegistry::viewFor() also falls back
 * to the generic view for any unresolved slug, so a missed remap here
 * degrades gracefully rather than 500ing a storefront.
 */
return new class extends Migration
{
    protected array $remap = [
        // System A (industry Blade homepage layouts)
        'wholesale' => 'marketverse',
        'grocery' => 'freshcart',
        'electronics' => 'novatech',
        'auto_parts' => 'generalhub',
        'autoparts' => 'generalhub',
        'digital_products' => 'technova',
        'digital' => 'technova',
        'bookstore' => 'elegance',
        'restaurant' => 'freshcart',
        'pharmacy' => 'generalhub',
        'pet_supplies' => 'urbana',
        'pet' => 'urbana',
        'marketplace' => 'marketverse',

        // System B (color-token-only themes)
        'beauty-glow' => 'veloura',
        'bookstore-classic' => 'elegance',
        'electronics-tech' => 'novatech',
        'fashion-edit' => 'voguelane',
        'fitness-power' => 'brutalex',
        'grocery-fresh' => 'freshcart',
        'jewelry-luxe' => 'veloura',
        'marketplace-mega' => 'marketverse',
        'pawluxe-pets' => 'urbana',
        'restaurant-fresh' => 'freshcart',
    ];

    public function up(): void
    {
        if (! Schema::hasTable('store_settings')) {
            return;
        }

        foreach ($this->remap as $old => $new) {
            DB::table('store_settings')->where('theme', $old)->update(['theme' => $new]);
        }
    }

    public function down(): void
    {
        // Not reversible — the original per-tenant slug isn't recoverable.
    }
};
