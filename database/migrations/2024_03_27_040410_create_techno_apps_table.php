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
        Schema::create('techno_apps', function (Blueprint $table) {
            // $table->id();
            // $table->uuid('id')->primary();

            $table->uuid('app_id');
            $table->uuid('techno_id');
            $table->timestamps();
            $table->softDeletes();

            // Primary key dengan kombinasi app_id dan techno_id
            $table->primary(['app_id', 'techno_id']);

            // Foreign key constraints
            $table->foreign('app_id')->references('id')->on('applications')->onDelete('cascade');

            $table->foreign('techno_id')->references('id')->on('technologies')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('techno_apps');
    }
};
