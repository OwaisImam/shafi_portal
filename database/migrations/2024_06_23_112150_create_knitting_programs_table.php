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
        Schema::create('knitting_programs', function (Blueprint $table) {
            $table->id();
            $table->integer('job_id');
            $table->integer('order_id');
            $table->text('description')->nullable();
            $table->string('fabric_content')->nullable();
            $table->string('article_id')->nullable();
            $table->string('required_finished_gsm')->nullable();
            $table->string('required_finished_width')->nullable();
            $table->string('required_finished_quality')->nullable();
            $table->string('shade_matching_light')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('knitting_programs');
    }
};
