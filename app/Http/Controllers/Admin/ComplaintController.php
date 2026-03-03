<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Complaint;
use App\Models\Resident;
use Illuminate\Http\Request;

class ComplaintController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $complaints = Complaint::with('resident.room.floor')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('admin.complaints.index', compact('complaints'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $residents = Resident::where('status', 'active')->with('room')->orderBy('name')->get();
        return view('admin.complaints.create', compact('residents'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'category' => 'required|in:Noise,Parking,Cleanliness,Security,Water,Electricity,Neighbor,Common Area,Other',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,under_review,resolved,rejected',
        ]);

        Complaint::create($validated);
        return redirect()->route('admin.complaints.index')->with('success', 'Complaint recorded successfully!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $complaint = Complaint::findOrFail($id);
        $residents = Resident::where('status', 'active')->with('room')->orderBy('name')->get();
        return view('admin.complaints.edit', compact('complaint', 'residents'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $complaint = Complaint::findOrFail($id);

        $validated = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'title' => 'required|string|max:200',
            'description' => 'required|string|max:1000',
            'category' => 'required|in:Noise,Parking,Cleanliness,Security,Water,Electricity,Neighbor,Common Area,Other',
            'priority' => 'required|in:low,medium,high',
            'status' => 'required|in:pending,under_review,resolved,rejected',
        ]);

        $complaint->update($validated);
        return redirect()->route('admin.complaints.index')->with('success', 'Complaint updated!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Complaint::findOrFail($id)->delete();
        return redirect()->route('admin.complaints.index')->with('success', 'Complaint deleted!');
    }
}