<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        if (Schema::hasColumn('service_jobs', 'scheduled_date')) {
            Schema::table('service_jobs', function (Blueprint $table) {
                $table->dateTime('scheduled_date')->nullable()->change();
            });
        }
    }

    public function down(): void
    {
        if (Schema::hasColumn('service_jobs', 'scheduled_date')) {
            Schema::table('service_jobs', function (Blueprint $table) {
                $table->date('scheduled_date')->nullable()->change();
            });
        }
    }
};
