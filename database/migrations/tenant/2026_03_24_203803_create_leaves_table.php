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
        Schema::create('leaves', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->integer('employee_id')->index();
            $table->integer('company_id')->index();
            $table->integer('department_id')->index();
            $table->integer('leave_type_id')->index();
            $table->date('start_date');
            $table->date('end_date');
            $table->string('days', 192);
            $table->text('reason')->nullable();
            $table->string('attachment', 192)->nullable();
            $table->boolean('half_day')->nullable();
            $table->string('status', 192);
            $table->timestamps(6);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('leaves');
    }
};
