<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Maintenance;
use App\Models\Room;
use App\Models\Resident;
use Illuminate\Http\Request;

class MaintenanceController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $maintenances = Maintenance::with(['room.floor', 'resident'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.maintenance.index', compact('maintenances'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $rooms = Room::with('floor')->orderBy('room_number')->get();
        $residents = Resident::where('status', 'active')->orderBy('name')->get();
        return view('admin.maintenance.create', compact('rooms', 'residents'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'resident_id' => 'nullable|exists:residents,id',
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'category' => 'required|in:Plumbing,Electrical,Carpentry,Painting,Cleaning,Security,Other',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'scheduled_date' => 'nullable|date',
            'cost' => 'nullable|numeric|min:0',
            'assigned_to' => 'nullable|string|max:150',
        ]);

        Maintenance::create($validated);
        return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance request added!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $maintenance = Maintenance::findOrFail($id);
        $rooms = Room::with('floor')->orderBy('room_number')->get();
        $residents = Resident::where('status', 'active')->orderBy('name')->get();
        return view('admin.maintenance.edit', compact('maintenance', 'rooms', 'residents'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $maintenance = Maintenance::findOrFail($id);

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'resident_id' => 'nullable|exists:residents,id',
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'category' => 'required|in:Plumbing,Electrical,Carpentry,Painting,Cleaning,Security,Other',
            'priority' => 'required|in:low,medium,high,urgent',
            'status' => 'required|in:pending,in_progress,completed,cancelled',
            'scheduled_date' => 'nullable|date',
            'cost' => 'nullable|numeric|min:0',
            'assigned_to' => 'nullable|string|max:150',
        ]);

        $maintenance->update($validated);
        return redirect()->route('admin.maintenance.index')->with('success', 'Maintenance updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Maintenance::findOrFail($id)->delete();
        return redirect()->route('admin.maintenance.index')->with('success', 'Record deleted!');
    }
}