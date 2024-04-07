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
        Schema::create('customers', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('contact_number', 25)->nullable();
            $table->string('email', 75)->nullable();
            $table->string('address')->nullable();
            $table->string('contact_person_name', 100)->nullable();
            $table->string('contact_person_number', 25)->nullable();
            $table->string('drug_license_number', 50)->nullable();
            $table->unsignedBigInteger('state');
            $table->string('delivery_method', 25)->nullable();
            $table->decimal('credit_limit', 8, 2)->default(0);
            $table->unsignedBigInteger('created_by');
            $table->unsignedBigInteger('updated_by');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('customers');
    }
};
