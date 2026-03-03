<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Maintenance;
use App\Models\Room;
use App\Models\Resident;

class MaintenanceSeeder extends Seeder
{
    public function run()
    {
        $rooms = Room::all();
        $categories = ['Plumbing', 'Electrical', 'Carpentry', 'Painting', 'Cleaning', 'Security', 'Other'];
        $priorities = ['low', 'medium', 'high', 'urgent'];
        $statuses = ['pending', 'in_progress', 'completed'];

        $titles = [
            'Water leakage in bathroom', 'Fan not working', 'Door hinge broken',
            'Wall paint chipping', 'Common area cleaning required', 'CCTV camera malfunction',
            'Kitchen sink blocked', 'Switchboard sparking', 'Window glass cracked',
            'Roof seepage after rain', 'Elevator maintenance check', 'Water pump repair',
            'Corridor light bulb replacement', 'Parking gate stuck', 'Gas pipeline inspection',
        ];

        for ($i = 0; $i < 20; $i++) {
            $room = $rooms->random();
            $resident = Resident::where('room_id', $room->id)->first();

            Maintenance::create([
                'room_id' => $room->id,
                'resident_id' => $resident ? $resident->id : null,
                'title' => $titles[$i % count($titles)],
                'description' => 'Maintenance work required. Please address at earliest convenience.',
                'category' => $categories[array_rand($categories)],
                'priority' => $priorities[array_rand($priorities)],
                'status' => $statuses[array_rand($statuses)],
                'scheduled_date' => now()->addDays(rand(1, 14)),
                'cost' => rand(500, 15000),
                'assigned_to' => ['Ram Electrician', 'Suresh Plumber', 'Ahmed Carpenter', 'Ravi Painter'][rand(0, 3)],
            ]);
        }
    }
}