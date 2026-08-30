<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

/**
 * Monochra is now the storefront's default theme — the plain, unthemed
 * "default" option has been removed from the theme picker entirely (along
 * with "Real Estate Theme", per product decision). Any store still on the
 * generic "default" slug gets switched to Monochra so it actually renders
 * one of the 20 designed themes; real_estate stores are left untouched
 * since that's a distinct, still-functional storefront controller, just no
 * longer offered as a fresh pick in the theme gallery.
 */
return new class extends Migration
{
    public function up(): void
    {
        if (! Schema::hasTable('store_settings')) {
            return;
        }

        Schema::table('store_settings', function (Blueprint $table) {
            $table->string('theme', 32)->default('monochra')->change();
        });

        DB::table('store_settings')->where('theme', 'default')->update(['theme' => 'monochra']);
        DB::table('store_settings')->whereNull('theme')->update(['theme' => 'monochra']);
    }

    public function down(): void
    {
        if (! Schema::hasTable('store_settings')) {
            return;
        }

        Schema::table('store_settings', function (Blueprint $table) {
            $table->string('theme', 32)->default('default')->change();
        });
    }
};
