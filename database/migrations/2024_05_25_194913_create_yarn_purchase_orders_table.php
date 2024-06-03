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
        Schema::create('yarn_purchase_orders', function (Blueprint $table) {
            $table->id();
            $table->integer('count_id')->nullable();
            $table->integer('fiber_id')->nullable();
            $table->integer('mill_id')->nullable();
            $table->integer('fabric_construction_id')->nullable();
            $table->integer('terms_of_delivery_id')->nullable();
            $table->integer('agent_id')->nullable();
            $table->integer('order_id')->nullable();
            $table->double('lbs')->nullable();
            $table->double('kgs')->nullable();
            $table->double('qty')->nullable();
            $table->string('unit')->nullable();
            $table->integer('price_per_lb')->nullable();
            $table->integer('amount')->nullable();
            $table->integer('with_gst')->nullable();
            $table->string('date_of_purchase')->nullable();
            $table->integer('terms_of_payment')->nullable();
            $table->integer('contract_no')->nullable();
            $table->integer('job_id')->nullable();
            $table->string('remarks')->nullable();
            $table->double('delivered')->nullable();
            $table->double('balance')->nullable();
            $table->date('delivery_date')->nullable();
            $table->string('invoice_of')->nullable();
            $table->double('completion_in')->nullable();
            $table->boolean('status')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yarn_purchase_orders');
    }
};