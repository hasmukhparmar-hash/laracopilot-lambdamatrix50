<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Room;
use App\Models\Floor;
use Illuminate\Http\Request;

class RoomController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $rooms = Room::with(['floor', 'residents'])
            ->orderBy('floor_id')
            ->orderBy('room_number')
            ->paginate(20);

        $floors = Floor::orderBy('floor_number')->get();

        return view('admin.rooms.index', compact('rooms', 'floors'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $floors = Floor::orderBy('floor_number')->get();
        return view('admin.rooms.create', compact('floors'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'floor_id' => 'required|exists:floors,id',
            'room_number' => 'required|string|max:20',
            'room_type' => 'required|in:1BHK,2BHK,3BHK,Studio,Penthouse',
            'area_sqft' => 'required|numeric|min:100',
            'monthly_rent' => 'required|numeric|min:0',
            'status' => 'required|in:vacant,occupied,maintenance',
            'description' => 'nullable|string|max:500',
        ]);

        Room::create($validated);
        return redirect()->route('admin.rooms.index')->with('success', 'Room added successfully!');
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $room = Room::with(['floor', 'residents', 'maintenances', 'complaints'])->findOrFail($id);
        return view('admin.rooms.show', compact('room'));
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $room = Room::findOrFail($id);
        $floors = Floor::orderBy('floor_number')->get();
        return view('admin.rooms.edit', compact('room', 'floors'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $room = Room::findOrFail($id);

        $validated = $request->validate([
            'floor_id' => 'required|exists:floors,id',
            'room_number' => 'required|string|max:20',
            'room_type' => 'required|in:1BHK,2BHK,3BHK,Studio,Penthouse',
            'area_sqft' => 'required|numeric|min:100',
            'monthly_rent' => 'required|numeric|min:0',
            'status' => 'required|in:vacant,occupied,maintenance',
            'description' => 'nullable|string|max:500',
        ]);

        $room->update($validated);
        return redirect()->route('admin.rooms.index')->with('success', 'Room updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Room::findOrFail($id)->delete();
        return redirect()->route('admin.rooms.index')->with('success', 'Room deleted successfully!');
    }
}