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
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();
            $table->string('platenumber');
            $table->string('type');
            $table->string('name');
            $table->string('condition');
            $table->string('description')->default('');
            $table->string('status')->default('pending');
            $table->string('isdel')->nullable()->default('active');
            $table->unsignedBigInteger('drivers_id');
            $table->foreign('drivers_id')->references('id')->on('drivers')->onDelete('cascade');            
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('vehicles');
    }
};
