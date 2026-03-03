<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Inspection;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Medicine;
use App\Models\MedicineStock;
use Illuminate\Http\Request;

class InspectionController extends Controller
{
    private function authCheck()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        return null;
    }

    public function index()
    {
        if ($r = $this->authCheck()) return $r;

        $inspections = Inspection::with(['patient', 'doctor'])
            ->orderBy('inspection_date', 'desc')
            ->paginate(20);

        return view('clinic.inspections.index', compact('inspections'));
    }

    public function create()
    {
        if ($r = $this->authCheck()) return $r;

        if (session('clinic_role') === 'nurse') {
            $perms = session('nurse_permissions', []);
            if (!in_array('create_inspection', $perms)) {
                return back()->with('error', 'You do not have permission to create inspections.');
            }
        }

        $patients  = Patient::orderBy('name')->get();
        $doctors   = Doctor::where('active', true)->orderBy('name')->get();
        $medicines = Medicine::with('stock')->orderBy('name')->get();
        return view('clinic.inspections.create', compact('patients', 'doctors', 'medicines'));
    }

    public function store(Request $request)
    {
        if ($r = $this->authCheck()) return $r;

        $validated = $request->validate([
            'patient_id'       => 'required|exists:patients,id',
            'doctor_id'        => 'required|exists:doctors,id',
            'inspection_date'  => 'required|date',
            'chief_complaint'  => 'required|string|max:500',
            'diagnosis'        => 'required|string|max:1000',
            'symptoms'         => 'nullable|string|max:1000',
            'vitals_bp'        => 'nullable|string|max:20',
            'vitals_temp'      => 'nullable|string|max:20',
            'vitals_pulse'     => 'nullable|string|max:20',
            'vitals_weight'    => 'nullable|string|max:20',
            'notes'            => 'nullable|string|max:2000',
            'follow_up_date'   => 'nullable|date|after:inspection_date',
            'medicines'        => 'nullable|array',
            'medicines.*.medicine_id' => 'required|exists:medicines,id',
            'medicines.*.dosage'      => 'required|string|max:100',
            'medicines.*.duration'    => 'required|string|max:100',
            'medicines.*.quantity'    => 'required|integer|min:1',
        ]);

        $inspection = Inspection::create([
            'patient_id'      => $validated['patient_id'],
            'doctor_id'       => $validated['doctor_id'],
            'inspection_date' => $validated['inspection_date'],
            'chief_complaint' => $validated['chief_complaint'],
            'diagnosis'       => $validated['diagnosis'],
            'symptoms'        => $validated['symptoms'] ?? null,
            'vitals_bp'       => $validated['vitals_bp'] ?? null,
            'vitals_temp'     => $validated['vitals_temp'] ?? null,
            'vitals_pulse'    => $validated['vitals_pulse'] ?? null,
            'vitals_weight'   => $validated['vitals_weight'] ?? null,
            'notes'           => $validated['notes'] ?? null,
            'follow_up_date'  => $validated['follow_up_date'] ?? null,
        ]);

        // Attach medicines
        if (!empty($validated['medicines'])) {
            foreach ($validated['medicines'] as $med) {
                $inspection->medicines()->attach($med['medicine_id'], [
                    'dosage'   => $med['dosage'],
                    'duration' => $med['duration'],
                    'quantity' => $med['quantity'],
                ]);

                // Deduct from stock
                $stock = MedicineStock::where('medicine_id', $med['medicine_id'])->first();
                if ($stock && $stock->quantity >= $med['quantity']) {
                    $stock->decrement('quantity', $med['quantity']);
                }
            }
        }

        return redirect()->route('inspections.show', $inspection->id)->with('success', 'Inspection recorded!');
    }

    public function show($id)
    {
        if ($r = $this->authCheck()) return $r;
        $inspection = Inspection::with(['patient', 'doctor', 'medicines'])->findOrFail($id);
        return view('clinic.inspections.show', compact('inspection'));
    }

    public function edit($id)
    {
        if ($r = $this->authCheck()) return $r;
        $inspection = Inspection::findOrFail($id);
        $patients   = Patient::orderBy('name')->get();
        $doctors    = Doctor::where('active', true)->get();
        $medicines  = Medicine::orderBy('name')->get();
        return view('clinic.inspections.edit', compact('inspection', 'patients', 'doctors', 'medicines'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->authCheck()) return $r;

        $inspection = Inspection::findOrFail($id);

        $validated = $request->validate([
            'patient_id'      => 'required|exists:patients,id',
            'doctor_id'       => 'required|exists:doctors,id',
            'inspection_date' => 'required|date',
            'chief_complaint' => 'required|string|max:500',
            'diagnosis'       => 'required|string|max:1000',
            'symptoms'        => 'nullable|string|max:1000',
            'vitals_bp'       => 'nullable|string|max:20',
            'vitals_temp'     => 'nullable|string|max:20',
            'vitals_pulse'    => 'nullable|string|max:20',
            'vitals_weight'   => 'nullable|string|max:20',
            'notes'           => 'nullable|string|max:2000',
            'follow_up_date'  => 'nullable|date',
        ]);

        $inspection->update($validated);
        return redirect()->route('inspections.show', $id)->with('success', 'Inspection updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->authCheck()) return $r;
        if (session('clinic_role') !== 'admin') return back()->with('error', 'Admin only.');
        Inspection::findOrFail($id)->delete();
        return redirect()->route('inspections.index')->with('success', 'Inspection deleted.');
    }
}