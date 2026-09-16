<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        DB::table('landing_seo')
            ->where('favicon', 'images/super/settings/favicon.ico')
            ->update(['favicon' => 'images/super/landing-design/quantro/quantro-q.png']);
    }

    public function down(): void
    {
        DB::table('landing_seo')
            ->where('favicon', 'images/super/landing-design/quantro/quantro-q.png')
            ->update(['favicon' => 'images/super/settings/favicon.ico']);
    }
};
