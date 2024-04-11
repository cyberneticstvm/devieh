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
        Schema::create('sales', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('customer_id');
            $table->string('sale_note')->nullable();
            $table->string('invoice', 25)->nullable()->unique();
            $table->decimal('total', 7, 2)->default(0);
            $table->decimal('discount', 7, 2)->default(0);
            $table->decimal('total_after_discount', 7, 2)->default(0);
            $table->decimal('advance', 7, 2)->default(0);
            $table->decimal('balance', 7, 2)->default(0);
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('updated_by')->default(0);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sales');
    }
};
