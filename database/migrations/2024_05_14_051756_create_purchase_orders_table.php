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
        Schema::create('purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->string('serial_no')->nullable();
            $table->string('credit_days')->nullable();
            $table->string('category_id')->nullable();
            $table->string('supplier_id')->nullable();
            $table->string('gst_no')->nullable();
            $table->string('ntn_no')->nullable();
            $table->string('contact_person')->nullable();
            $table->string('mobile_no')->nullable();
            $table->string('job_no')->nullable();
            $table->string('required_delivery_date')->nullable();
            $table->string('delivery_address')->nullable();
            $table->string('status')->nullable();
            $table->string('sub_total')->nullable();
            $table->string('discount')->nullable();
            $table->string('gross_value_before_gst')->nullable();
            $table->string('gst')->nullable();
            $table->string('total')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('purchase_orders');
    }
};