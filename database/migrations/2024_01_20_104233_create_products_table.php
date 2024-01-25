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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('category_id');
            $table->unsignedBigInteger('subcategory_id');
            $table->string('name');
            $table->string('code', 15)->unique();
            $table->string('image')->nullable();
            $table->decimal('price', 7, 2)->default(0);
            $table->string('description')->nullable();
            $table->enum('eligible_for_commission', ['Yes', 'No'])->default('No');
            $table->foreign('subcategory_id')->references('id')->on('subcategories')->onDelete('restrict');
            $table->foreign('category_id')->references('id')->on('subcategories')->onDelete('restrict');
            $table->unique(['category_id', 'subcategory_id', 'name']);
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
