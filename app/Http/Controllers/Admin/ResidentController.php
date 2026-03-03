<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Resident;
use App\Models\Room;
use Illuminate\Http\Request;

class ResidentController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $residents = Resident::with('room.floor')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.residents.index', compact('residents'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $rooms = Room::with('floor')->where('status', '!=', 'maintenance')->orderBy('room_number')->get();
        return view('admin.residents.create', compact('rooms'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'nullable|email|max:150',
            'phone' => 'required|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'move_in_date' => 'required|date',
            'move_out_date' => 'nullable|date|after:move_in_date',
            'id_proof_type' => 'required|in:Aadhar,PAN,Passport,Driving License',
            'id_proof_number' => 'required|string|max:50',
            'emergency_contact' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            'members_count' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        Resident::create($validated);

        // Update room status
        Room::findOrFail($request->room_id)->update(['status' => 'occupied']);

        return redirect()->route('admin.residents.index')->with('success', 'Resident registered successfully!');
    }

    public function show($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $resident = Resident::with(['room.floor', 'complaints', 'maintenances', 'visitors'])->findOrFail($id);
        return view('admin.residents.show', compact('resident'));
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $resident = Resident::findOrFail($id);
        $rooms = Room::with('floor')->orderBy('room_number')->get();
        return view('admin.residents.edit', compact('resident', 'rooms'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $resident = Resident::findOrFail($id);

        $validated = $request->validate([
            'name' => 'required|string|max:150',
            'email' => 'nullable|email|max:150',
            'phone' => 'required|string|max:20',
            'room_id' => 'required|exists:rooms,id',
            'move_in_date' => 'required|date',
            'move_out_date' => 'nullable|date|after:move_in_date',
            'id_proof_type' => 'required|in:Aadhar,PAN,Passport,Driving License',
            'id_proof_number' => 'required|string|max:50',
            'emergency_contact' => 'nullable|string|max:20',
            'status' => 'required|in:active,inactive',
            'members_count' => 'required|integer|min:1',
            'notes' => 'nullable|string|max:500',
        ]);

        $resident->update($validated);
        return redirect()->route('admin.residents.index')->with('success', 'Resident updated successfully!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Resident::findOrFail($id)->delete();
        return redirect()->route('admin.residents.index')->with('success', 'Resident removed successfully!');
    }
}