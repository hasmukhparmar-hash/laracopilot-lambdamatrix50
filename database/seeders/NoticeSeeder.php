<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Notice;

class NoticeSeeder extends Seeder
{
    public function run()
    {
        $notices = [
            ['title' => 'Society Annual General Meeting', 'content' => 'All residents are cordially invited to attend the Annual General Meeting on 15th February 2025 at 7:00 PM in the Community Hall. Key agenda includes budget review, election of committee members, and planning of upcoming society events. Attendance is mandatory for all flat owners.', 'category' => 'Meeting', 'active' => true, 'expires_at' => now()->addDays(30)],
            ['title' => 'Water Supply Interruption Notice', 'content' => 'Please be informed that water supply will be interrupted on Saturday, 10th February 2025 from 10:00 AM to 4:00 PM due to maintenance work on the main pipeline. Residents are requested to store sufficient water. We regret the inconvenience caused.', 'category' => 'Maintenance', 'active' => true, 'expires_at' => now()->addDays(7)],
            ['title' => 'Monthly Maintenance Charges Due', 'content' => 'This is a reminder that monthly maintenance charges for February 2025 are due by 10th February. Amount: Rs. 2500/- per flat. Kindly pay through bank transfer to Society Account or drop cheque in the office. Late payment will attract penalty of Rs. 100/- per day.', 'category' => 'Payment', 'active' => true, 'expires_at' => now()->addDays(15)],
            ['title' => 'Holi Celebration 2025', 'content' => 'Society is organizing a grand Holi celebration on 14th March 2025 at the terrace from 10:00 AM onwards. Natural and organic colors will be provided. Special lunch for all residents. Children activities planned. Contact the secretary to volunteer and help organize.', 'category' => 'Event', 'active' => true, 'expires_at' => now()->addDays(45)],
            ['title' => 'Parking Rules Reminder', 'content' => 'Residents are reminded to park only in their designated spots. Visitor parking is strictly for guests only and limited to 4 hours. Vehicles parked without authorization will be towed at owner expense. Please cooperate to maintain orderly parking.', 'category' => 'General', 'active' => true, 'expires_at' => null],
            ['title' => 'Emergency: Security Alert', 'content' => 'Attention all residents! There have been reports of unknown individuals roaming the society premises. Please ensure all entry doors are locked. Do not allow unknown persons entry. Report suspicious activity immediately to security guard or call 100.', 'category' => 'Emergency', 'active' => true, 'expires_at' => now()->addDays(3)],
        ];

        foreach ($notices as $notice) {
            Notice::create($notice);
        }
    }
}