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
        Schema::create('branches', function (Blueprint $table) {
            $table->id();
            $table->string('name', 125)->unique();
            $table->string('title', 125)->unique();
            $table->string('code', 5)->unique();
            $table->string('gstin', 50)->nullable();
            $table->string('address')->nullable();
            $table->string('contact_number', 50)->nullable();
            $table->string('email', 50)->nullable();
            $table->integer('invoice_starts_with')->nullable();
            $table->unsignedBigInteger('invoice_type')->nullable();
            $table->string('drug_license_number', 50)->nullable();
            $table->integer('display_capacity')->nullable();
            $table->foreign('invoice_type')->references('id')->on('settings');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('branches');
    }
};
