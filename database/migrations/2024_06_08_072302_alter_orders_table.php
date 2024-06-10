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
        if(!Schema::hasColumn('orders', 'range_id')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('range_id');
            });
        }

        if(!Schema::hasColumn('orders', 'gsm')) {
            Schema::table('orders', function (Blueprint $table) {
                $table->dropColumn('gsm');
            });
        }

        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('range_id');
        });

        Schema::table('order_items', function (Blueprint $table) {
            $table->integer('gsm');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        if(Schema::hasColumn('order_items', 'range_id')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropColumn('range_id');
            });
        }

         if(Schema::hasColumn('order_items', 'gsm')) {
            Schema::table('order_items', function (Blueprint $table) {
                $table->dropColumn('gsm');
            });
        }

        Schema::table('orders', function (Blueprint $table) {
            $table->integer('range_id');
        });

         Schema::table('orders', function (Blueprint $table) {
            $table->integer('gsm');
        });
    }
};