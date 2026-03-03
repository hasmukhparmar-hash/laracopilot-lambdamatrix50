<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Floor;

class FloorSeeder extends Seeder
{
    public function run()
    {
        $floors = [
            ['floor_number' => 0, 'floor_name' => 'Ground Floor', 'description' => 'Ground level with parking and lobby area', 'total_rooms' => 8],
            ['floor_number' => 1, 'floor_name' => 'First Floor', 'description' => 'Premium apartments with garden view', 'total_rooms' => 10],
            ['floor_number' => 2, 'floor_name' => 'Second Floor', 'description' => 'Standard residential floor', 'total_rooms' => 10],
            ['floor_number' => 3, 'floor_name' => 'Third Floor', 'description' => 'Standard residential floor with balconies', 'total_rooms' => 10],
            ['floor_number' => 4, 'floor_name' => 'Fourth Floor', 'description' => 'Corner units with city view', 'total_rooms' => 8],
            ['floor_number' => 5, 'floor_name' => 'Fifth Floor - Penthouse', 'description' => 'Luxury penthouse and top-floor units', 'total_rooms' => 4],
        ];

        foreach ($floors as $floor) {
            Floor::create($floor);
        }
    }
}