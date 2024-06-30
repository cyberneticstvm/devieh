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
        Schema::create('order_details', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('order_id');
            $table->enum('eye', ['RE', 'LE', 'Both'])->nullable();
            $table->enum('product_type', ['Lens', 'Frame', 'Service'])->nullable();
            $table->string('sph', 6)->nullable();
            $table->string('cyl', 6)->nullable();
            $table->string('axis', 3)->nullable();
            $table->string('add', 6)->nullable();
            $table->string('dia', 6)->nullable();
            $table->string('ipd', 50)->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->integer('qty')->nullable();
            $table->decimal('price', 7, 2)->default(0);
            $table->decimal('total', 7, 2)->default(0);
            $table->foreign('order_id')->references('id')->on('orders')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_details');
    }
};
