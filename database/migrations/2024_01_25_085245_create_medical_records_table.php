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
        Schema::create('medical_records', function (Blueprint $table) {
            $table->id();
            $table->string('mrn', 25)->unique();
            $table->unsignedBigInteger('mrn_id')->unique();
            $table->string('name', 50);
            $table->integer('age');
            $table->enum('gender', ['Male', 'Female', 'Other']);
            $table->string('place', 125);
            $table->string('mobile', 10);
            $table->unsignedBigInteger('branch_id');
            $table->unsignedBigInteger('doctor_id');
            $table->decimal('consultation_fee', 7, 2)->nullable();
            $table->unsignedBigInteger('consultation_fee_payment_mode')->nullable();
            $table->enum('consultation_type', ['Appointment', 'Camp', 'Direct']);
            $table->enum('purpose_of_visit', ['License', 'Consultation']);
            $table->enum('review', ['Yes', 'No'])->nullable();
            $table->enum('cataract_surgery_advised', ['Yes', 'No'])->nullable();
            $table->enum('cataract_surgery_urgent', ['Yes', 'No'])->nullable();
            $table->date('post_review_date')->nullable();
            $table->string('op_reference', 25)->nullable();
            $table->unsignedBigInteger('status')->comment('Consultation / Order Status')->nullable();
            $table->unsignedBigInteger('created_by')->default(0);
            $table->unsignedBigInteger('updated_by')->default(0);
            $table->foreign('branch_id')->references('id')->on('branches');
            $table->foreign('doctor_id')->references('id')->on('doctors');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('medical_records');
    }
};
