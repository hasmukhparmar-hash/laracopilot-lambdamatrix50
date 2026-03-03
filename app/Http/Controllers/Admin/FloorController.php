<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Floor;
use App\Models\Room;
use Illuminate\Http\Request;

class FloorController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $floors = Floor::withCount(['rooms', 'rooms as occupied_count' => function ($q) {
            $q->where('status', 'occupied');
        }, 'rooms as vacant_count' => function ($q) {
            $q->where('status', 'vacant');
        }])->orderBy('floor_number')->get();

        return view('admin.floors.index', compact('floors'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        return view('admin.floors.create');
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'floor_number' => 'required|integer|min:0|unique:floors,floor_number',
            'floor_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'total_rooms' => 'required|integer|min:1',
        ]);

        Floor::create($validated);
        return redirect()->route('admin.floors.index')->with('success', 'Floor added successfully!');
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $floor = Floor::with(['rooms.residents'])->findOrFail($id);
        $rooms = Room::where('floor_id', $id)->with('residents')->orderBy('room_number')->get();

        return view('admin.floors.show', compact('floor', 'rooms'));
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $floor = Floor::findOrFail($id);
        return view('admin.floors.edit', compact('floor'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $floor = Floor::findOrFail($id);

        $validated = $request->validate([
            'floor_number' => 'required|integer|min:0|unique:floors,floor_number,' . $id,
            'floor_name' => 'required|string|max:100',
            'description' => 'nullable|string|max:500',
            'total_rooms' => 'required|integer|min:1',
        ]);

        $floor->update($validated);
        return redirect()->route('admin.floors.index')->with('success', 'Floor updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Floor::findOrFail($id)->delete();
        return redirect()->route('admin.floors.index')->with('success', 'Floor deleted successfully!');
    }
}