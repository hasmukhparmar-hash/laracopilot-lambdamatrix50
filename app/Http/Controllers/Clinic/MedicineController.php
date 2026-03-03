<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Medicine;
use App\Models\MedicineStock;
use Illuminate\Http\Request;

class MedicineController extends Controller
{
    private function authCheck()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        if (session('clinic_role') === 'nurse') return back()->with('error', 'Access denied.');
        return null;
    }

    public function index()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');

        $medicines = Medicine::with('stock')
            ->orderBy('name')
            ->paginate(20);

        return view('clinic.medicines.index', compact('medicines'));
    }

    public function create()
    {
        if ($r = $this->authCheck()) return $r;
        return view('clinic.medicines.create');
    }

    public function store(Request $request)
    {
        if ($r = $this->authCheck()) return $r;

        $validated = $request->validate([
            'name'           => 'required|string|max:200',
            'generic_name'   => 'nullable|string|max:200',
            'category'       => 'required|in:Tablet,Syrup,Injection,Capsule,Cream,Drops,Inhaler,Other',
            'manufacturer'   => 'nullable|string|max:150',
            'unit_price'     => 'required|numeric|min:0',
            'unit'           => 'required|in:Piece,Strip,Bottle,Vial,Tube,Box',
            'description'    => 'nullable|string|max:500',
            'side_effects'   => 'nullable|string|max:500',
            'contraindications' => 'nullable|string|max:500',
            'requires_prescription' => 'boolean',
        ]);

        $validated['requires_prescription'] = $request->has('requires_prescription');
        $medicine = Medicine::create($validated);

        // Create initial stock entry
        MedicineStock::create([
            'medicine_id'    => $medicine->id,
            'quantity'       => 0,
            'reorder_level'  => 10,
            'expiry_date'    => null,
        ]);

        return redirect()->route('medicines.index')->with('success', 'Medicine added!');
    }

    public function edit($id)
    {
        if ($r = $this->authCheck()) return $r;
        $medicine = Medicine::with('stock')->findOrFail($id);
        return view('clinic.medicines.edit', compact('medicine'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->authCheck()) return $r;

        $medicine = Medicine::findOrFail($id);

        $validated = $request->validate([
            'name'           => 'required|string|max:200',
            'generic_name'   => 'nullable|string|max:200',
            'category'       => 'required|in:Tablet,Syrup,Injection,Capsule,Cream,Drops,Inhaler,Other',
            'manufacturer'   => 'nullable|string|max:150',
            'unit_price'     => 'required|numeric|min:0',
            'unit'           => 'required|in:Piece,Strip,Bottle,Vial,Tube,Box',
            'description'    => 'nullable|string|max:500',
            'side_effects'   => 'nullable|string|max:500',
            'contraindications' => 'nullable|string|max:500',
        ]);

        $validated['requires_prescription'] = $request->has('requires_prescription');
        $medicine->update($validated);
        return redirect()->route('medicines.index')->with('success', 'Medicine updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->authCheck()) return $r;
        if (session('clinic_role') !== 'admin') return back()->with('error', 'Admin only.');
        Medicine::findOrFail($id)->delete();
        return redirect()->route('medicines.index')->with('success', 'Medicine deleted.');
    }
}