<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Complaint;
use App\Models\Resident;

class ComplaintSeeder extends Seeder
{
    public function run()
    {
        $residents = Resident::all();
        $categories = ['Noise', 'Parking', 'Cleanliness', 'Security', 'Water', 'Electricity', 'Neighbor', 'Common Area', 'Other'];
        $statuses = ['pending', 'under_review', 'resolved', 'rejected'];

        $complaints = [
            ['title' => 'Loud music late at night', 'category' => 'Noise'],
            ['title' => 'Unauthorized parking in my spot', 'category' => 'Parking'],
            ['title' => 'Garbage not collected on time', 'category' => 'Cleanliness'],
            ['title' => 'Suspicious activity near building', 'category' => 'Security'],
            ['title' => 'No water supply in morning', 'category' => 'Water'],
            ['title' => 'Frequent power cuts in flat', 'category' => 'Electricity'],
            ['title' => 'Neighbor causing disturbance', 'category' => 'Neighbor'],
            ['title' => 'Common area lights not working', 'category' => 'Common Area'],
            ['title' => 'Elevator too slow and noisy', 'category' => 'Other'],
            ['title' => 'Stray dogs in compound', 'category' => 'Security'],
            ['title' => 'Corridor not being cleaned', 'category' => 'Cleanliness'],
            ['title' => 'Low water pressure issue', 'category' => 'Water'],
        ];

        foreach ($complaints as $i => $complaint) {
            if ($residents->isEmpty()) break;
            $resident = $residents->random();

            Complaint::create([
                'resident_id' => $resident->id,
                'title' => $complaint['title'],
                'description' => 'This issue has been ongoing for some time. Requesting immediate attention from management.',
                'category' => $complaint['category'],
                'priority' => ['low', 'medium', 'high'][rand(0, 2)],
                'status' => $statuses[array_rand($statuses)],
            ]);
        }
    }
}