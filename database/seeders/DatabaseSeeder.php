<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run()
    {
        $this->call([
            FloorSeeder::class,
            RoomSeeder::class,
            ResidentSeeder::class,
            MaintenanceSeeder::class,
            ComplaintSeeder::class,
            NoticeSeeder::class,
            VisitorSeeder::class,
        ]);
    }
}