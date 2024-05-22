<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('code');
            $table->string('customer_po_number');
            $table->integer('customer_id');
            $table->integer('job_id');
            $table->date('po_receive_date');
            $table->date('delivery_date');
            $table->integer('pyment_term_id');
            $table->integer('range_id');
            $table->integer('fabric_cosntruction_id');
            $table->integer('gsm');
            $table->double('order_quantity');
            $table->integer('article_style_count');
            $table->timestamps();
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
