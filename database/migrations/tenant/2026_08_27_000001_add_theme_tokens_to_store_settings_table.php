<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

/**
 * Adds per-tenant token overrides (colors, fonts, radius) for the selected
 * storefront theme pack. Defaults are shipped in each theme's theme.json;
 * this column only stores the subset the tenant has customized from Store
 * Settings, keeping the theme packs themselves reusable/unmodified.
 */
return new class extends Migration
{
    public function up(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            if (! Schema::hasColumn('store_settings', 'theme_tokens')) {
                $table->json('theme_tokens')->nullable()->after('theme');
            }
        });
    }

    public function down(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            if (Schema::hasColumn('store_settings', 'theme_tokens')) {
                $table->dropColumn('theme_tokens');
            }
        });
    }
};
