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
        Schema::create('mechanic_maintenances', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('maintenance_id')->nullable(); // Make driver_id nullable
            $table->foreign('maintenance_id')
                ->references('id')
                ->on('maintenances')
                ->onDelete('cascade');

            $table->unsignedBigInteger('mechanic_id')->nullable(); // Make driver_id nullable
            $table->foreign('mechanic_id')
                ->references('id')
                ->on('mechanics')
                ->onDelete('set null');
            $table->string('mechanic_name')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('mechanic_maintenances');
    }
};
