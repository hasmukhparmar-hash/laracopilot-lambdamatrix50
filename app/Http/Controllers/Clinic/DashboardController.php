<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Doctor;
use App\Models\Nurse;
use App\Models\Medicine;
use App\Models\Inspection;
use App\Models\Bill;
use App\Models\MedicineStock;

class DashboardController extends Controller
{
    public function index()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');

        $role = session('clinic_role');

        $totalPatients     = Patient::count();
        $todayPatients     = Patient::whereDate('created_at', today())->count();
        $totalDoctors      = Doctor::count();
        $totalNurses       = Nurse::count();
        $totalMedicines    = Medicine::count();
        $lowStockCount     = MedicineStock::where('quantity', '<=', 10)->count();
        $todayInspections  = Inspection::whereDate('inspection_date', today())->count();
        $totalInspections  = Inspection::count();
        $thisMonthBills    = Bill::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->sum('total_amount');
        $totalBills        = Bill::sum('total_amount');
        $pendingBills      = Bill::where('payment_status', 'pending')->count();
        $repeatedPatients  = Patient::has('inspections', '>', 1)->count();

        $recentPatients    = Patient::latest()->take(5)->get();
        $recentInspections = Inspection::with(['patient', 'doctor'])->latest()->take(5)->get();
        $recentBills       = Bill::with('patient')->latest()->take(5)->get();
        $lowStockMedicines = MedicineStock::with('medicine')->where('quantity', '<=', 10)->take(5)->get();

        $monthlyIncome = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyIncome[$m] = Bill::whereMonth('created_at', $m)
                ->whereYear('created_at', now()->year)
                ->where('payment_status', 'paid')
                ->sum('total_amount');
        }

        return view('clinic.dashboard', compact(
            'totalPatients', 'todayPatients', 'totalDoctors', 'totalNurses',
            'totalMedicines', 'lowStockCount', 'todayInspections', 'totalInspections',
            'thisMonthBills', 'totalBills', 'pendingBills', 'repeatedPatients',
            'recentPatients', 'recentInspections', 'recentBills', 'lowStockMedicines',
            'monthlyIncome', 'role'
        ));
    }
}