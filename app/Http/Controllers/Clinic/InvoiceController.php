<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Bill;

class InvoiceController extends Controller
{
    private function authCheck()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        return null;
    }

    public function index()
    {
        if ($r = $this->authCheck()) return $r;

        $invoices = Bill::with(['patient', 'doctor'])
            ->where('payment_status', '!=', 'pending')
            ->orderBy('bill_date', 'desc')
            ->paginate(20);

        return view('clinic.invoices.index', compact('invoices'));
    }

    public function show($id)
    {
        if ($r = $this->authCheck()) return $r;
        $invoice = Bill::with(['patient', 'doctor', 'items', 'inspection'])->findOrFail($id);
        return view('clinic.invoices.show', compact('invoice'));
    }

    public function print($id)
    {
        if ($r = $this->authCheck()) return $r;
        $invoice = Bill::with(['patient', 'doctor', 'items'])->findOrFail($id);
        return view('clinic.invoices.print', compact('invoice'));
    }
}