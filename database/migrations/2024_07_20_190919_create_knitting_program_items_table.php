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
            $table->integer('order_id');
            $table->integer('count_id');
            $table->integer('fiber_id');
            $table->integer('percentage');
            $table->double('kgs');
            $table->double('bags');
            $table->double('required_kgs');
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