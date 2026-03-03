<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Room;
use App\Models\Floor;

class RoomSeeder extends Seeder
{
    public function run()
    {
        $floors = Floor::all();

        $roomTypes = ['1BHK', '2BHK', '3BHK', 'Studio'];
        $statuses = ['vacant', 'occupied', 'occupied', 'occupied', 'vacant', 'maintenance'];

        foreach ($floors as $floor) {
            for ($i = 1; $i <= $floor->total_rooms; $i++) {
                $type = $floor->floor_number == 5 ? 'Penthouse' : $roomTypes[array_rand($roomTypes)];
                $rent = match($type) {
                    '1BHK' => rand(8000, 12000),
                    '2BHK' => rand(12000, 18000),
                    '3BHK' => rand(18000, 25000),
                    'Studio' => rand(6000, 9000),
                    'Penthouse' => rand(35000, 60000),
                };

                Room::create([
                    'floor_id' => $floor->id,
                    'room_number' => $floor->floor_number . sprintf('%02d', $i),
                    'room_type' => $type,
                    'area_sqft' => rand(400, 1800),
                    'monthly_rent' => $rent,
                    'status' => $statuses[array_rand($statuses)],
                    'description' => 'Well-maintained ' . $type . ' unit on ' . $floor->floor_name,
                ]);
            }
        }
    }
}