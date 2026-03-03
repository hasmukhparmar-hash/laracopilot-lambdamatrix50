@extends('layouts.clinic')
@section('title','Monthly Report')
@section('page-title','Monthly Report')
@section('breadcrumb','Home / Reports / Monthly')

@section('content')
<div class="py-4">
    <!-- Filter -->
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form method="GET" action="{{ route('reports.monthly') }}" class="flex items-end space-x-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Month</label>
                <select name="month" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
                    @foreach(range(1,12) as $m)
                    <option value="{{ $m }}" {{ $month == $m ? 'selected' : '' }}>{{ date('F', mktime(0,0,0,$m,1)) }}</option>
                    @endforeach
                </select>
            </div>
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                <select name="year" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
                    @foreach(range(date('Y')-3, date('Y')) as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-search mr-2"></i>Generate</button>
        </form>
    </div>

    <!-- Summary -->
    <div class="grid grid-cols-4 gap-4 mb-6">
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-blue-700">{{ $patients->count() }}</div>
            <div class="text-xs text-gray-500">Patients Visited</div>
        </div>
        <div class="bg-green-50 border border-green-100 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-green-700">{{ $totalInspections }}</div>
            <div class="text-xs text-gray-500">Total Inspections</div>
        </div>
        <div class="bg-purple-50 border border-purple-100 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-purple-700">{{ $newPatients }}</div>
            <div class="text-xs text-gray-500">New Patients</div>
        </div>
        <div class="bg-emerald-50 border border-emerald-100 rounded-xl p-4 text-center">
            <div class="text-xl font-bold text-emerald-700">₹{{ number_format($totalIncome) }}</div>
            <div class="text-xs text-gray-500">Total Income</div>
        </div>
    </div>

    <!-- Patient Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-700">Patient-wise Report — {{ date('F', mktime(0,0,0,$month,1)) }} {{ $year }}</h3>
        </div>
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Patient</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Visits</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Diagnosis</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Doctor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Amount Paid</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($patients as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="font-medium text-sm text-gray-800">{{ $p->name }}</div>
                        <div class="text-xs text-gray-400">{{ $p->patient_id }} &bull; {{ $p->phone }}</div>
                    </td>
                    <td class="px-4 py-3"><span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full font-semibold">{{ $p->inspections->count() }}</span></td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        @foreach($p->inspections->take(2) as $insp)
                        <div class="truncate max-w-xs">{{ $insp->diagnosis }}</div>
                        @endforeach
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        @foreach($p->inspections->take(2) as $insp)
                        <div>{{ $insp->doctor->name ?? 'N/A' }}</div>
                        @endforeach
                    </td>
                    <td class="px-4 py-3 font-semibold text-green-700">₹{{ number_format($p->bills->sum('total_amount')) }}</td>
                    <td class="px-4 py-3">
                        <a href="{{ route('reports.patient', $p->id) }}" class="text-xs bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700">Full Report</a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400">No patient data for selected month.</td></tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection
