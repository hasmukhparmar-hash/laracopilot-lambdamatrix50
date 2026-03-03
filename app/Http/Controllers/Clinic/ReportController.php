<?php

namespace App\Http\Controllers\Clinic;

use App\Http\Controllers\Controller;
use App\Models\Patient;
use App\Models\Bill;
use App\Models\Inspection;
use Illuminate\Http\Request;

class ReportController extends Controller
{
    private function adminOrDoctor()
    {
        if (!session('clinic_logged_in')) return redirect()->route('login');
        if (session('clinic_role') === 'nurse') return back()->with('error', 'Access denied.');
        return null;
    }

    public function index()
    {
        if ($r = $this->adminOrDoctor()) return $r;
        return view('clinic.reports.index');
    }

    public function monthly(Request $request)
    {
        if ($r = $this->adminOrDoctor()) return $r;

        $month = $request->get('month', now()->month);
        $year  = $request->get('year', now()->year);

        $patients = Patient::whereHas('inspections', function ($q) use ($month, $year) {
            $q->whereMonth('inspection_date', $month)->whereYear('inspection_date', $year);
        })->with(['inspections' => function ($q) use ($month, $year) {
            $q->whereMonth('inspection_date', $month)->whereYear('inspection_date', $year)->with('doctor');
        }, 'bills' => function ($q) use ($month, $year) {
            $q->whereMonth('bill_date', $month)->whereYear('bill_date', $year);
        }])->get();

        $totalInspections = Inspection::whereMonth('inspection_date', $month)->whereYear('inspection_date', $year)->count();
        $totalIncome      = Bill::whereMonth('bill_date', $month)->whereYear('bill_date', $year)->where('payment_status', 'paid')->sum('total_amount');
        $totalBills       = Bill::whereMonth('bill_date', $month)->whereYear('bill_date', $year)->count();
        $newPatients      = Patient::whereMonth('created_at', $month)->whereYear('created_at', $year)->count();

        return view('clinic.reports.monthly', compact(
            'patients', 'month', 'year', 'totalInspections', 'totalIncome', 'totalBills', 'newPatients'
        ));
    }

    public function patientReport($id)
    {
        if ($r = $this->adminOrDoctor()) return $r;

        $patient = Patient::with([
            'inspections.doctor',
            'inspections.medicines',
            'bills.items',
        ])->findOrFail($id);

        $totalVisits  = $patient->inspections->count();
        $totalSpent   = $patient->bills->sum('total_amount');
        $firstVisit   = $patient->inspections->sortBy('inspection_date')->first();
        $lastVisit    = $patient->inspections->sortByDesc('inspection_date')->first();
        $isRepeated   = $totalVisits > 1;
        $diagnosisList = $patient->inspections->pluck('diagnosis')->unique()->values();

        return view('clinic.reports.patient', compact(
            'patient', 'totalVisits', 'totalSpent', 'firstVisit', 'lastVisit', 'isRepeated', 'diagnosisList'
        ));
    }

    public function income(Request $request)
    {
        if ($r = $this->adminOrDoctor()) return $r;

        $year = $request->get('year', now()->year);

        $monthlyData = [];
        for ($m = 1; $m <= 12; $m++) {
            $monthlyData[$m] = [
                'income'     => Bill::whereMonth('bill_date', $m)->whereYear('bill_date', $year)->where('payment_status', 'paid')->sum('total_amount'),
                'pending'    => Bill::whereMonth('bill_date', $m)->whereYear('bill_date', $year)->where('payment_status', 'pending')->sum('total_amount'),
                'patients'   => Inspection::whereMonth('inspection_date', $m)->whereYear('inspection_date', $year)->distinct('patient_id')->count(),
                'inspections'=> Inspection::whereMonth('inspection_date', $m)->whereYear('inspection_date', $year)->count(),
            ];
        }

        $yearTotal   = Bill::whereYear('bill_date', $year)->where('payment_status', 'paid')->sum('total_amount');
        $yearPending = Bill::whereYear('bill_date', $year)->where('payment_status', 'pending')->sum('total_amount');

        return view('clinic.reports.income', compact('monthlyData', 'year', 'yearTotal', 'yearPending'));
    }

    public function repeatedPatients()
    {
        if ($r = $this->adminOrDoctor()) return $r;

        $patients = Patient::withCount('inspections')
            ->has('inspections', '>', 1)
            ->orderBy('inspections_count', 'desc')
            ->paginate(20);

        return view('clinic.reports.repeated', compact('patients'));
    }
}