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
        Schema::table('yarn_purchase_orders', function (Blueprint $table) {
            if(Schema::hasColumn('yarn_purchase_orders', 'delivered')) {
                $table->removeColumn('delivered');
            }

            if(Schema::hasColumn('yarn_purchase_orders', 'balance')) {
                $table->removeColumn('balance');
            }
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('yarn_purchase_orders', function (Blueprint $table) {
            $table->double('delivered')->nullable();
            $table->double('balance')->nullable();
        });
    }
};
