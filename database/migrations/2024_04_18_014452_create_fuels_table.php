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
        Schema::create('fuels', function (Blueprint $table) {
            $table->id();
            $table->string('fuel_type');
            $table->decimal('fuel_quantity', 8, 2);
            $table->decimal('fuel_cost', 8, 2);
            $table->string('status')->default('unavailable');
            $table->string('isdel')->nullable()->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('fuels');
    }
};
