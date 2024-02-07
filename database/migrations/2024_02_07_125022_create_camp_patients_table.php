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
        Schema::create('camp_patients', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('camp_id');
            $table->string('name', 50);
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('place', 125);
            $table->string('mobile', 10);
            $table->dateTime('registration_date')->nullable();
            $table->text('notes')->nullable();
            $table->unsignedBigInteger('mrn_id')->nullable();
            $table->foreign('camp_id')->references('id')->on('camps')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('camp_patients');
    }
};
