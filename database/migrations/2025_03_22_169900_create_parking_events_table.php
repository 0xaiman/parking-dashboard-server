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
        Schema::create('parking_events', function (Blueprint $table) {
            $table->id();
            $table->foreignId('device_id')->constrained('devices')->onDelete('cascade');
            $table->foreignId('space_id')->constrained('parking_spaces')->onDelete('cascade');
            $table->timestamp('event_time');
            $table->string('report_type');
            $table->boolean('occupancy');
            $table->integer('duration')->nullable();
            $table->integer('coordinate_x1')->nullable();
            $table->integer('coordinate_y1')->nullable();
            $table->integer('coordinate_x2')->nullable();
            $table->integer('coordinate_y2')->nullable();
            $table->timestamps();
        });
        
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_events');
    }
};
