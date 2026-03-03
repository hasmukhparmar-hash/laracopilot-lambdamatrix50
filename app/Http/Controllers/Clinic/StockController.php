<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\MedicineStock;
use App\Models\Medicine;
use Illuminate\Http\Request;

class StockController extends Controller
{
    private function authCheck()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        return null;
    }

    public function index()
    {
        if ($r = $this->authCheck()) return $r;

        $stocks = MedicineStock::with('medicine')
            ->orderByRaw('quantity <= reorder_level DESC')
            ->orderBy('quantity')
            ->paginate(20);

        $lowStockCount    = MedicineStock::where('quantity', '<=', 10)->count();
        $outOfStockCount  = MedicineStock::where('quantity', 0)->count();
        $expiringSoon     = MedicineStock::where('expiry_date', '<=', now()->addDays(30))->whereNotNull('expiry_date')->count();

        return view('clinic.stock.index', compact('stocks', 'lowStockCount', 'outOfStockCount', 'expiringSoon'));
    }

    public function create()
    {
        if ($r = $this->authCheck()) return $r;
        $medicines = Medicine::orderBy('name')->get();
        return view('clinic.stock.create', compact('medicines'));
    }

    public function store(Request $request)
    {
        if ($r = $this->authCheck()) return $r;

        $validated = $request->validate([
            'medicine_id'   => 'required|exists:medicines,id',
            'quantity'      => 'required|integer|min:1',
            'reorder_level' => 'required|integer|min:1',
            'expiry_date'   => 'nullable|date|after:today',
            'batch_number'  => 'nullable|string|max:50',
            'purchase_price'=> 'nullable|numeric|min:0',
            'supplier'      => 'nullable|string|max:150',
        ]);

        $stock = MedicineStock::where('medicine_id', $validated['medicine_id'])->first();

        if ($stock) {
            $stock->quantity += $validated['quantity'];
            $stock->reorder_level = $validated['reorder_level'];
            $stock->expiry_date   = $validated['expiry_date'] ?? $stock->expiry_date;
            $stock->batch_number  = $validated['batch_number'] ?? $stock->batch_number;
            $stock->save();
        } else {
            MedicineStock::create($validated);
        }

        return redirect()->route('stock.index')->with('success', 'Stock updated successfully!');
    }

    public function edit($id)
    {
        if ($r = $this->authCheck()) return $r;
        $stock     = MedicineStock::with('medicine')->findOrFail($id);
        $medicines = Medicine::orderBy('name')->get();
        return view('clinic.stock.edit', compact('stock', 'medicines'));
    }

    public function update(Request $request, $id)
    {
        if ($r = $this->authCheck()) return $r;

        $stock = MedicineStock::findOrFail($id);

        $validated = $request->validate([
            'quantity'      => 'required|integer|min:0',
            'reorder_level' => 'required|integer|min:1',
            'expiry_date'   => 'nullable|date',
            'batch_number'  => 'nullable|string|max:50',
        ]);

        $stock->update($validated);
        return redirect()->route('stock.index')->with('success', 'Stock updated!');
    }
}