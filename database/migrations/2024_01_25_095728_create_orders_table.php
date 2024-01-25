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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('medical_record_id');
            $table->string('auth_code', 25)->nullable()->unique();
            $table->boolean('fwc')->default(0);
            $table->boolean('hdl')->default(0);
            $table->boolean('noa')->default(0);
            $table->boolean('urg')->default(0);
            $table->boolean('tpc')->default(0);
            $table->enum('case_type', ['Rexine', 'Box'])->nullable();
            $table->unsignedBigInteger('product_advisor')->nullable();
            $table->string('remarks')->nullable();
            $table->string('invoice', 25)->nullable()->unique();
            $table->dateTime('invoice_date')->nullable();
            $table->decimal('total', 7, 2)->default(0);
            $table->decimal('discount', 7, 2)->default(0);
            $table->decimal('total_after_discount', 7, 2)->default(0);
            $table->decimal('advance', 7, 2)->default(0);
            $table->decimal('balance', 7, 2)->default(0);
            $table->unsignedBigInteger('advance_payment_mode')->nullable();
            $table->unsignedBigInteger('balance_payment_mode')->nullable();
            $table->unsignedBigInteger('order_status')->nullable();
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('updated_by')->default(0);
            $table->foreign('medical_record_id')->references('id')->on('medical_records')->onDelete('restrict');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
