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
        Schema::create('sale_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('sale_id');
            $table->unsignedBigInteger('item');
            $table->string('batch_number', 50)->nullable();
            $table->date('expiry_date')->nullable();
            $table->integer('qty');
            $table->integer('qty_free')->default(0);
            $table->decimal('price', 7, 2)->default(0);
            $table->decimal('total', 7, 2)->default(0);
            $table->integer('tax_percentage')->default(0);
            $table->decimal('taxable_amount')->default(0);
            $table->decimal('discount')->default(0);
            $table->foreign('sale_id')->references('id')->on('sales')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('sale_details');
    }
};
