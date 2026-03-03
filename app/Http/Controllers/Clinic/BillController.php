<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Bill;
use App\Models\BillItem;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Inspection;
use App\Models\Medicine;
use Illuminate\Http\Request;

class BillController extends Controller
{
    private function authCheck()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        if (session('clinic_role') === 'nurse') return back()->with('error', 'Nurses cannot manage bills.');
        return null;
    }

    public function index()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');

        $bills = Bill::with(['patient', 'doctor'])
            ->orderBy('created_at', 'desc')
            ->paginate(20);

        $totalRevenue  = Bill::where('payment_status', 'paid')->sum('total_amount');
        $pendingAmount = Bill::where('payment_status', 'pending')->sum('total_amount');

        return view('clinic.bills.index', compact('bills', 'totalRevenue', 'pendingAmount'));
    }

    public function create()
    {
        if ($r = $this->authCheck()) return $r;
        $patients   = Patient::orderBy('name')->get();
        $doctors    = Doctor::where('active', true)->get();
        $medicines  = Medicine::orderBy('name')->get();
        $inspections = Inspection::with('patient')->orderBy('inspection_date', 'desc')->take(50)->get();
        return view('clinic.bills.create', compact('patients', 'doctors', 'medicines', 'inspections'));
    }

    public function store(Request $request)
    {
        if ($r = $this->authCheck()) return $r;

        $validated = $request->validate([
            'patient_id'     => 'required|exists:patients,id',
            'doctor_id'      => 'required|exists:doctors,id',
            'inspection_id'  => 'nullable|exists:inspections,id',
            'bill_date'      => 'required|date',
            'payment_status' => 'required|in:pending,paid,partial',
            'payment_method' => 'nullable|in:Cash,Card,UPI,Online,Insurance',
            'discount'       => 'nullable|numeric|min:0',
            'notes'          => 'nullable|string|max:500',
            'items'          => 'required|array|min:1',
            'items.*.description' => 'required|string|max:200',
            'items.*.quantity'    => 'required|integer|min:1',
            'items.*.unit_price'  => 'required|numeric|min:0',
        ]);

        $subtotal = 0;
        foreach ($request->items as $item) {
            $subtotal += $item['quantity'] * $item['unit_price'];
        }

        $discount    = $validated['discount'] ?? 0;
        $totalAmount = $subtotal - $discount;
        $billNumber  = 'BILL-' . date('Ymd') . '-' . rand(100, 999);

        $bill = Bill::create([
            'patient_id'     => $validated['patient_id'],
            'doctor_id'      => $validated['doctor_id'],
            'inspection_id'  => $validated['inspection_id'] ?? null,
            'bill_number'    => $billNumber,
            'bill_date'      => $validated['bill_date'],
            'subtotal'       => $subtotal,
            'discount'       => $discount,
            'total_amount'   => $totalAmount,
            'payment_status' => $validated['payment_status'],
            'payment_method' => $validated['payment_method'] ?? null,
            'notes'          => $validated['notes'] ?? null,
        ]);

        foreach ($request->items as $item) {
            BillItem::create([
                'bill_id'     => $bill->id,
                'description' => $item['description'],
                'quantity'    => $item['quantity'],
                'unit_price'  => $item['unit_price'],
                'total'       => $item['quantity'] * $item['unit_price'],
            ]);
        }

        return redirect()->route('bills.show', $bill->id)->with('success', 'Bill created successfully!');
    }

    public function show($id)
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        $bill = Bill::with(['patient', 'doctor', 'items', 'inspection'])->findOrFail($id);
        return view('clinic.bills.show', compact('bill'));
    }

    public function edit($id)
    {
        if ($r = $this->authCheck()) return $r;
        $bill    = Bill::with('items')->findOrFail($id);
        $patients = Patient::orderBy('name')->get();
        $doctors  = Doctor::where('active', true)->get();
        return view('clinic.bills.edit', compact('bill', 'patients', 'doctors'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->authCheck()) return $r;

        $bill = Bill::findOrFail($id);

        $validated = $request->validate([
            'payment_status' => 'required|in:pending,paid,partial',
            'payment_method' => 'nullable|in:Cash,Card,UPI,Online,Insurance',
            'discount'       => 'nullable|numeric|min:0',
            'notes'          => 'nullable|string|max:500',
        ]);

        $bill->update($validated);
        return redirect()->route('bills.show', $id)->with('success', 'Bill updated!');
    }

    public function destroy($id)
    {
        if ($r = $this->authCheck()) return $r;
        if (session('clinic_role') !== 'admin') return back()->with('error', 'Admin only.');
        Bill::findOrFail($id)->delete();
        return redirect()->route('bills.index')->with('success', 'Bill deleted.');
    }
}