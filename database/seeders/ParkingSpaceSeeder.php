<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingLevel;
use App\Models\ParkingSpace;

class ParkingSpaceSeeder extends Seeder
{
    public function run()
    {
        // Retrieve all parking levels
        $levels = ParkingLevel::all();

        foreach ($levels as $level) {
            // For example, create 10 spaces per level
            for ($i = 1; $i <= 10; $i++) {
                ParkingSpace::create([
                    'level_id' => $level->id,
                    // Naming convention: Use first letter of level name + number (e.g., G01, L1E02)
                    'name' => strtoupper(substr($level->name, 0, 1)) . str_pad($i, 2, '0', STR_PAD_LEFT),
                    'status' => 'vacant'
                ]);
            }
        }
    }
}
