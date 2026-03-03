<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Visitor;
use App\Models\Resident;
use Illuminate\Http\Request;

class VisitorController extends Controller
{
    public function index()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $visitors = Visitor::with('resident.room.floor')
            ->orderBy('visit_date', 'desc')
            ->paginate(20);

        return view('admin.visitors.index', compact('visitors'));
    }

    public function create()
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $residents = Resident::where('status', 'active')->with('room')->orderBy('name')->get();
        return view('admin.visitors.create', compact('residents'));
    }

    public function store(Request $request)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $validated = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'visitor_name' => 'required|string|max:150',
            'visitor_phone' => 'required|string|max:20',
            'purpose' => 'required|string|max:200',
            'visit_date' => 'required|date',
            'check_in' => 'required',
            'check_out' => 'nullable',
            'vehicle_number' => 'nullable|string|max:20',
            'id_proof' => 'nullable|string|max:100',
        ]);

        Visitor::create($validated);
        return redirect()->route('admin.visitors.index')->with('success', 'Visitor logged successfully!');
    }

    public function edit($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        $visitor = Visitor::findOrFail($id);
        $residents = Resident::where('status', 'active')->with('room')->orderBy('name')->get();
        return view('admin.visitors.edit', compact('visitor', 'residents'));
    }

    public function update(Request $request, $id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');

        $visitor = Visitor::findOrFail($id);

        $validated = $request->validate([
            'resident_id' => 'required|exists:residents,id',
            'visitor_name' => 'required|string|max:150',
            'visitor_phone' => 'required|string|max:20',
            'purpose' => 'required|string|max:200',
            'visit_date' => 'required|date',
            'check_in' => 'required',
            'check_out' => 'nullable',
            'vehicle_number' => 'nullable|string|max:20',
            'id_proof' => 'nullable|string|max:100',
        ]);

        $visitor->update($validated);
        return redirect()->route('admin.visitors.index')->with('success', 'Visitor record updated!');
    }

    public function destroy($id)
    {
        if (!session('admin_logged_in')) return redirect()->route('admin.login');
        Visitor::findOrFail($id)->delete();
        return redirect()->route('admin.visitors.index')->with('success', 'Visitor record deleted!');
    }
}