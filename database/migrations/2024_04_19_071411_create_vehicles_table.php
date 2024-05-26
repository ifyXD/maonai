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
            $table->string('seat_capacity')->nullable();
            $table->unsignedBigInteger('driver_id')->nullable(); // Make driver_id nullable
            $table->foreign('driver_id')
                ->references('id')
                ->on('drivers')
                ->onDelete('set null'); // Use 'set null' for on delete action
        
            $table->unsignedBigInteger('fuel_id')->nullable(); // Make fuel_id nullable
            $table->foreign('fuel_id')
                ->references('id')
                ->on('fuels')
                ->onDelete('set null'); // Use 'set null' for on delete action 
                
            // $table->string('condition');
            $table->string('description')->default('');
            $table->string('status')->default('pending');
            $table->string('isdel')->nullable()->default('active');
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
