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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name')->nullable();
            $table->string('email')->nullable();
            $table->string('phone')->nullable();
            $table->string('second_email')->nullable();
            $table->integer('city_id')->nullable();
            $table->integer('state_id')->nullable();
            $table->integer('country_id')->nullable();
            $table->string('website')->nullable();
            $table->boolean('is_emailed')->default(0);
            $table->boolean('is_called')->default(0);
            $table->boolean('follow_up_call')->nullable();
            $table->string('follow_up_date')->nullable();
            $table->string('remarks')->nullable();
            $table->integer('created_by')->nullable();
            $table->enum('status', ['interested', 'not_interested'])->default('not_interested');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};