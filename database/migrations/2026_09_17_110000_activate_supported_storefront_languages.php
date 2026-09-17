<?php

use App\Models\Central\CentralLanguage;
use Illuminate\Database\Migrations\Migration;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        CentralLanguage::whereIn('locale', ['en', 'ar', 'fr', 'es', 'de', 'pt', 'tr'])
            ->update(['is_active' => true]);

        CentralLanguage::whereIn('locale', ['hi', 'bn'])
            ->update(['is_active' => false]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        CentralLanguage::whereIn('locale', ['fr', 'es', 'de', 'pt', 'tr'])
            ->update(['is_active' => false]);
    }
};
