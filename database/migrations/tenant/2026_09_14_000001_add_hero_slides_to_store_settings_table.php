<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            // Ordered list of hero slides: [{title, subtitle, image, cta_text,
            // cta_link}, ...]. Empty/absent -> themes fall back to the legacy
            // single hero_title/hero_subtitle/hero_image_path fields, so
            // existing stores see no change until a merchant adds slides.
            $table->json('hero_slides')->nullable()->after('hero_image_path');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_settings', function (Blueprint $table) {
            $table->dropColumn('hero_slides');
        });
    }
};
