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
        Schema::create('knitting_program_items', function (Blueprint $table) {
            $table->id();
            $table->integer('knitting_program_id');
            $table->integer('body_fabric');
            $table->double('body_fabric_dozen');
            $table->double('fabric_detail_kgs');
            $table->double('order_qty');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knitting_program_items');
    }
};