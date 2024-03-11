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
        Schema::create('transfers', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('from_branch')->default(0);
            $table->unsignedBigInteger('to_branch')->default(0);
            $table->text('transfer_note')->nullable();
            $table->enum('type', ['store', 'pharmacy', 'other'])->nullable();
            $table->unsignedBigInteger('purchase_id')->comment("Whether this transfer occurred via purchase or not")->nullable();
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
        Schema::dropIfExists('transfers');
    }
};
