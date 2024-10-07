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
        Schema::create('vm_apps', function (Blueprint $table) {
            // $table->id();
            //$table->uuid('id')->primary();

            $table->uuid('app_id');
            $table->uuid('vm_id');
            $table->string('environment')->nullable();
            $table->timestamps();
            $table->softDeletes();

            // Primary key dengan kombinasi app_id dan vm_id
            $table->primary(['app_id', 'vm_id']);

            // Foreign key constraints
            $table->foreign('app_id')->references('id')->on('applications')->onDelete('cascade');
            
            $table->foreign('vm_id')->references('id')->on('virtual_machines')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vm_apps');
    }
};
