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
        Schema::create('yarn_stocks', function (Blueprint $table) {
            $table->id();
            $table->integer('yarn_purchase_order_id');
            $table->integer('parent_stock_id')->nullable();
            $table->double('total_qty');
            $table->double('received_qty')->nullable();
            $table->double('remaining_qty')->nullable();
            $table->integer('cartage_slip_id')->nullable();
            $table->string('received_from_type')->nullable();
            $table->integer('received_from_id')->nullable();
            $table->string('deliver_to_type')->nullable();
            $table->integer('deliver_to_id')->nullable();
            $table->enum('type', ['Shortfall', 'Normal'])->default('Normal');
            $table->enum('status', ['Received', 'Delivered', 'Pending', 'Not Delivered','Not Received', 'Missing'])->default('Pending');
            $table->text('remarks')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('yarn_stocks');
    }
};
