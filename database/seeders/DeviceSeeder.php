<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class DeviceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $devices = [];
        for ($i = 1; $i <= 50; $i++) {
            $devices[] = [
                'device_name' => "MPC_$i",
                'channel' => rand(1, 4),
                'resolution_w' => 2304,
                'resolution_h' => 1296,
                'created_at' => now(),
                'updated_at' => now(),
            ];
        }
        DB::table('devices')->insert($devices);
    }
}