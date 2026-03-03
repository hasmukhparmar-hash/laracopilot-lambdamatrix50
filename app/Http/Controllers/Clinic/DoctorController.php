<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Doctor;
use Illuminate\Http\Request;

class DoctorController extends Controller
{
    private function adminOnly()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        if (session('clinic_role') !== 'admin') return back()->with('error', 'Admin access required.');
        return null;
    }

    public function index()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        $doctors = Doctor::withCount('inspections')->orderBy('name')->paginate(20);
        return view('clinic.doctors.index', compact('doctors'));
    }

    public function create()
    {
        if ($r = $this->adminOnly()) return $r;
        return view('clinic.doctors.create');
    }

    public function store(Request $request)
    {
        if ($r = $this->adminOnly()) return $r;

        $validated = $request->validate([
            'name'           => 'required|string|max:150',
            'specialization' => 'required|string|max:150',
            'email'          => 'nullable|email|max:150',
            'phone'          => 'required|string|max:20',
            'qualification'  => 'nullable|string|max:200',
            'experience_years' => 'nullable|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'active'         => 'boolean',
            'schedule'       => 'nullable|string|max:500',
        ]);

        $validated['active'] = $request->has('active');
        Doctor::create($validated);
        return redirect()->route('doctors.index')->with('success', 'Doctor added!');
    }

    public function edit($id)
    {
        if ($r = $this->adminOnly()) return $r;
        $doctor = Doctor::findOrFail($id);
        return view('clinic.doctors.edit', compact('doctor'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->adminOnly()) return $r;

        $doctor = Doctor::findOrFail($id);

        $validated = $request->validate([
            'name'           => 'required|string|max:150',
            'specialization' => 'required|string|max:150',
            'email'          => 'nullable|email|max:150',
            'phone'          => 'required|string|max:20',
            'qualification'  => 'nullable|string|max:200',
            'experience_years' => 'nullable|integer|min:0',
            'consultation_fee' => 'required|numeric|min:0',
            'schedule'       => 'nullable|string|max:500',
        ]);

        $validated['active'] = $request->has('active');
        $doctor->update($validated);
        return redirect()->route('doctors.index')->with('success', 'Doctor updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->adminOnly()) return $r;
        Doctor::findOrFail($id)->delete();
        return redirect()->route('doctors.index')->with('success', 'Doctor removed.');
    }
}