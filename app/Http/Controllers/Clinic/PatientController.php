<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Doctor;
use Illuminate\Http\Request;

class PatientController extends Controller
{
    private function authCheck()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        return null;
    }

    public function index()
    {
        if ($r = $this->authCheck()) return $r;

        $patients = Patient::with(['inspections', 'bills'])
            ->withCount('inspections')
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        return view('clinic.patients.index', compact('patients'));
    }

    public function create()
    {
        if ($r = $this->authCheck()) return $r;
        $doctors = Doctor::where('active', true)->get();
        return view('clinic.patients.create', compact('doctors'));
    }

    public function store(Request $request)
    {
        if ($r = $this->authCheck()) return $r;

        $validated = $request->validate([
            'name'            => 'required|string|max:150',
            'age'             => 'required|integer|min:0|max:150',
            'gender'          => 'required|in:Male,Female,Other',
            'phone'           => 'required|string|max:20',
            'email'           => 'nullable|email|max:150',
            'address'         => 'nullable|string|max:500',
            'blood_group'     => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'dob'             => 'nullable|date',
            'emergency_contact' => 'nullable|string|max:20',
            'allergies'       => 'nullable|string|max:500',
            'chronic_diseases'=> 'nullable|string|max:500',
            'referred_by'     => 'nullable|string|max:150',
        ]);

        $validated['patient_id'] = 'PAT-' . strtoupper(substr(str_replace(' ', '', $validated['name']), 0, 3)) . rand(1000, 9999);

        Patient::create($validated);
        return redirect()->route('patients.index')->with('success', 'Patient registered successfully!');
    }

    public function show($id)
    {
        if ($r = $this->authCheck()) return $r;

        $patient = Patient::with([
            'inspections.doctor',
            'inspections.medicines',
            'bills',
        ])->findOrFail($id);

        $visitCount     = $patient->inspections->count();
        $totalSpent     = $patient->bills->sum('total_amount');
        $lastVisit      = $patient->inspections->sortByDesc('inspection_date')->first();
        $isRepeated     = $visitCount > 1;

        return view('clinic.patients.show', compact('patient', 'visitCount', 'totalSpent', 'lastVisit', 'isRepeated'));
    }

    public function edit($id)
    {
        if ($r = $this->authCheck()) return $r;
        $patient = Patient::findOrFail($id);
        $doctors = Doctor::where('active', true)->get();
        return view('clinic.patients.edit', compact('patient', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->authCheck()) return $r;

        $patient = Patient::findOrFail($id);

        $validated = $request->validate([
            'name'            => 'required|string|max:150',
            'age'             => 'required|integer|min:0',
            'gender'          => 'required|in:Male,Female,Other',
            'phone'           => 'required|string|max:20',
            'email'           => 'nullable|email|max:150',
            'address'         => 'nullable|string|max:500',
            'blood_group'     => 'nullable|in:A+,A-,B+,B-,AB+,AB-,O+,O-',
            'dob'             => 'nullable|date',
            'emergency_contact' => 'nullable|string|max:20',
            'allergies'       => 'nullable|string|max:500',
            'chronic_diseases'=> 'nullable|string|max:500',
            'referred_by'     => 'nullable|string|max:150',
        ]);

        $patient->update($validated);
        return redirect()->route('patients.show', $id)->with('success', 'Patient updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->authCheck()) return $r;
        if (session('clinic_role') !== 'admin') return back()->with('error', 'Access denied.');
        Patient::findOrFail($id)->delete();
        return redirect()->route('patients.index')->with('success', 'Patient deleted.');
    }
}