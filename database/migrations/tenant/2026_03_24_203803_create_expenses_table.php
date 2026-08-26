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
        Schema::create('expenses', function (Blueprint $table) {
            $table->collation = 'utf8mb4_unicode_ci';
            $table->charset = 'utf8mb4';

            $table->integer('id', true);
            $table->date('date');
            $table->string('Ref', 192);
            $table->integer('user_id')->index();
            $table->integer('expense_category_id')->index();
            $table->integer('warehouse_id')->index();
            $table->integer('account_id')->nullable()->index();
            $table->string('details', 192);
            $table->decimal('amount', 15);
            $table->integer('payment_method_id')->nullable()->index();
            $table->timestamps(6);
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
