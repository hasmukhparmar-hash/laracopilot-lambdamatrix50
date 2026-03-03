<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Resident;
use App\Models\Room;

class ResidentSeeder extends Seeder
{
    public function run()
    {
        $names = ['Rajesh Kumar', 'Priya Sharma', 'Amit Patel', 'Sunita Verma', 'Vikram Singh', 'Meena Joshi', 'Arun Gupta', 'Kavitha Reddy', 'Suresh Nair', 'Divya Menon', 'Manoj Tiwari', 'Rekha Agarwal', 'Deepak Malhotra', 'Anita Kapoor', 'Rahul Bose', 'Seema Pillai', 'Sanjay Dubey', 'Nisha Chawla', 'Vivek Saxena', 'Pooja Iyer'];
        $idTypes = ['Aadhar', 'PAN', 'Passport', 'Driving License'];

        $occupiedRooms = Room::where('status', 'occupied')->get();

        foreach ($occupiedRooms as $index => $room) {
            $name = $names[$index % count($names)];
            Resident::create([
                'room_id' => $room->id,
                'name' => $name,
                'email' => strtolower(str_replace(' ', '.', $name)) . '@email.com',
                'phone' => '98' . rand(10000000, 99999999),
                'move_in_date' => now()->subMonths(rand(1, 36)),
                'id_proof_type' => $idTypes[array_rand($idTypes)],
                'id_proof_number' => strtoupper(substr(str_replace(' ', '', $name), 0, 3)) . rand(100000, 999999),
                'emergency_contact' => '97' . rand(10000000, 99999999),
                'status' => 'active',
                'members_count' => rand(1, 5),
                'notes' => 'Registered resident. Background verified.',
            ]);
        }
    }
}