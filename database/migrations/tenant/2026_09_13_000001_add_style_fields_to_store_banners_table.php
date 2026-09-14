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
        Schema::table('store_banners', function (Blueprint $table) {
            $table->string('badge_text')->nullable()->after('title');
            $table->string('subtitle')->nullable()->after('badge_text');
            $table->string('button_text')->nullable()->after('link');
            $table->string('bg_color')->nullable()->after('button_text');
            $table->string('bg_color_2')->nullable()->after('bg_color');
            $table->string('text_color')->nullable()->after('bg_color_2');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('store_banners', function (Blueprint $table) {
            $table->dropColumn(['badge_text', 'subtitle', 'button_text', 'bg_color', 'bg_color_2', 'text_color']);
        });
    }
};
