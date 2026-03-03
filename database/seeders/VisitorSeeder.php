<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Visitor;
use App\Models\Resident;

class VisitorSeeder extends Seeder
{
    public function run()
    {
        $residents = Resident::all();
        $purposes = ['Personal Visit', 'Delivery', 'Repair Work', 'Family Visit', 'Official Work', 'Domestic Help', 'Medical Visit', 'Courier Delivery'];

        if ($residents->isEmpty()) return;

        for ($i = 0; $i < 30; $i++) {
            $resident = $residents->random();
            $hour = rand(8, 20);
            $checkIn = sprintf('%02d:%02d', $hour, rand(0, 59));
            $checkOut = rand(0, 1) ? sprintf('%02d:%02d', $hour + rand(1, 3), rand(0, 59)) : null;

            Visitor::create([
                'resident_id' => $resident->id,
                'visitor_name' => ['Ramesh Sharma', 'Priya Singh', 'Kumar Raj', 'Sita Devi', 'Mohan Das', 'Lata Gupta', 'Ajay Mehta', 'Kavita Jain'][rand(0, 7)],
                'visitor_phone' => '90' . rand(10000000, 99999999),
                'purpose' => $purposes[array_rand($purposes)],
                'visit_date' => now()->subDays(rand(0, 30)),
                'check_in' => $checkIn,
                'check_out' => $checkOut,
                'vehicle_number' => rand(0, 1) ? 'MH' . rand(10, 99) . chr(rand(65, 90)) . chr(rand(65, 90)) . rand(1000, 9999) : null,
                'id_proof' => ['Aadhar - ' . rand(100000000000, 999999999999), 'DL - MH' . rand(10000, 99999), null][rand(0, 2)],
            ]);
        }
    }
}