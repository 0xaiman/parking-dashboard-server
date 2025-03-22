<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ParkingLevel;

class ParkingLevelSeeder extends Seeder
{
    public function run()
    {
        $levels = [
            'Ground',
            'Level 1 East Wing',
            'Level 2 East Wing',
            'Level 1 West Wing',
            'Level 2 West Wing',
            'Rooftop',
        ];

        foreach ($levels as $levelName) {
            ParkingLevel::create(['name' => $levelName]);
        }
    }
}
