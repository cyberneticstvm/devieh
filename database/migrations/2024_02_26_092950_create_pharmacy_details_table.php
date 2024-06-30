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
        Schema::create('pharmacy_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->unsignedBigInteger('product_id')->nullable();
            $table->string('batch_number', 50)->nullable();
            $table->integer('qty')->nullable();
            $table->string('dosage')->nullable();
            $table->string('duration')->nullable();
            $table->decimal('price', 7, 2)->default(0);
            $table->decimal('total', 7, 2)->default(0);
            $table->foreign('order_id')->references('id')->on('pharmacies')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pharmacy_details');
    }
};
