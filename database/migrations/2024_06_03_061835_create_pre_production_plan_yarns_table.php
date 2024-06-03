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
        Schema::create('pre_production_plan_yarns', function (Blueprint $table) {
            $table->id();
            $table->integer('yarn_purchase_order_id');
            $table->integer('pre_production_plan_id');
            $table->double('qty')->default(0);
            $table->double('kgs')->default(0);
            $table->double('percentage')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pre_production_plan_yarns');
    }
};
