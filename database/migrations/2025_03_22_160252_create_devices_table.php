<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('devices', function (Blueprint $table) {
            $table->id(); // BIGINT (PK) Auto-increment
            $table->string('device_name', 50)->unique(); // Unique device identifier
            $table->integer('channel'); // Camera channel
            $table->integer('resolution_w'); // Width of camera resolution
            $table->integer('resolution_h'); // Height of camera resolution
            $table->timestamps(); // created_at & updated_at
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};
