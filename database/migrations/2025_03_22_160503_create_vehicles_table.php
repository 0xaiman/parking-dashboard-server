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
            $table->id(); // BIGINT (PK) Auto-increment
            // $table->foreignId('parking_event_id')->constrained('parking_events')->onDelete('cascade'); // Foreign key reference
            $table->string('license_plate', 15); // License Plate
            $table->string('plate_color', 20); // Plate color
            $table->string('vehicle_type', 20); // Type (Car, Bike, etc.)
            $table->string('vehicle_color', 20); // Vehicle color
            $table->string('vehicle_brand', 50)->nullable(); // Vehicle brand (optional)
            $table->timestamps(); // created_at & updated_at
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
