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
        Schema::create('cartage_slips', function (Blueprint $table) {
            $table->id();
            $table->integer('order_id')->nullable();
            $table->integer('job_id')->nullable();
            $table->double('slip_no')->nullable();
            $table->string('delivery_from_type')->nullable();
            $table->integer('delivery_from_id')->nullable();
            $table->string('delivery_to_type')->nullable();
            $table->integer('delivery_to_id')->nullable();
            $table->string('driver_name')->nullable();
            $table->string('driver_cell_no')->nullable();
            $table->string('vehicle_no')->nullable();
            $table->string('vehicle_type')->nullable();
            $table->string('amount')->nullable();
            $table->integer('upload_id')->nullable();
            $table->string('amount_in_words')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('cartage_slips');
    }
};