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
        Schema::table('vehicles', function (Blueprint $table) {
            $table->string('owner')->after('vehicle_brand')->default('unknown');
            $table->enum('membership_status', ['staff', 'guest', 'member'])->default('guest')->after('owner');
            $table->integer('visit_count')->default(0)->after('membership_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('vehicles', function (Blueprint $table) {
            $table->dropColumn(['owner', 'membership_status', 'visit_count']);
        });
    }
};
