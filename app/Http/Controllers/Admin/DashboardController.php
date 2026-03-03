<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\Room;
use App\Models\Resident;
use App\Models\Maintenance;
use App\Models\Complaint;
use App\Models\Visitor;
use App\Models\Notice;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) {
            return redirect()->route('admin.login');
        }

        $totalFloors = Floor::count();
        $totalRooms = Room::count();
        $occupiedRooms = Room::where('status', 'occupied')->count();
        $vacantRooms = Room::where('status', 'vacant')->count();
        $totalResidents = Resident::count();
        $pendingComplaints = Complaint::where('status', 'pending')->count();
        $pendingMaintenance = Maintenance::where('status', 'pending')->count();
        $todayVisitors = Visitor::whereDate('visit_date', today())->count();
        $totalNotices = Notice::where('active', true)->count();
        $occupancyRate = $totalRooms > 0 ? round(($occupiedRooms / $totalRooms) * 100, 1) : 0;

        $recentResidents = Resident::with('room.floor')->latest()->take(5)->get();
        $recentComplaints = Complaint::with('resident')->latest()->take(5)->get();
        $recentVisitors = Visitor::with('resident')->latest()->take(5)->get();
        $activeNotices = Notice::where('active', true)->latest()->take(3)->get();

        $floorStats = Floor::withCount(['rooms', 'rooms as occupied_rooms_count' => function ($q) {
            $q->where('status', 'occupied');
        }])->get();

        $maintenanceByStatus = [
            'pending' => Maintenance::where('status', 'pending')->count(),
            'in_progress' => Maintenance::where('status', 'in_progress')->count(),
            'completed' => Maintenance::where('status', 'completed')->count(),
        ];

        return view('admin.dashboard', compact(
            'totalFloors', 'totalRooms', 'occupiedRooms', 'vacantRooms',
            'totalResidents', 'pendingComplaints', 'pendingMaintenance',
            'todayVisitors', 'totalNotices', 'occupancyRate',
            'recentResidents', 'recentComplaints', 'recentVisitors',
            'activeNotices', 'floorStats', 'maintenanceByStatus'
        ));
    }
}