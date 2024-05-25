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
        Schema::create('request_vehicles', function (Blueprint $table) {
            $table->id();  
            $table->string('name');
            $table->unsignedBigInteger('vehicle_id');
            $table->bigInteger('capacity');
            $table->foreign('vehicle_id')->references('id')->on('vehicles')->onDelete('cascade');  
            $table->string('purpose');
            $table->enum('status', ['pending', 'accept', 'decline'])->default('pending');
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');  
            $table->unsignedBigInteger('drivers_id');
            $table->foreign('drivers_id')->references('id')->on('drivers')->onDelete('cascade');  
            $table->dateTime('appointment');
            $table->string('appointment_end');
            $table->string('isdel')->nullable()->default('active');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('request_vehicles');
    }
};
