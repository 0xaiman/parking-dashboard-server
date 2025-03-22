<?php 

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('parking_spaces', function (Blueprint $table) {
            $table->id(); // BIGINT (PK) Auto-increment
            $table->foreignId('level_id')->constrained('parking_levels')->onDelete('cascade'); // Foreign key reference
            $table->string('name', 50); // Space name (e.g., "G01")
            $table->enum('status', ['occupied', 'vacant'])->default('vacant'); // ENUM for space status
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('parking_spaces');
    }
};