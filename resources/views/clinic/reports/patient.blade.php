@extends('layouts.clinic')
@section('title','Patient Report')
@section('page-title','Patient Report')
@section('breadcrumb','Home / Reports / Patient')

@section('content')
<div class="py-4 max-w-4xl">
    <!-- Header -->
    <div class="bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white mb-6">
        <div class="flex justify-between items-start">
            <div>
                <h2 class="text-2xl font-bold">{{ $patient->name }}</h2>
                <div class="text-blue-100 text-sm mt-1">{{ $patient->patient_id }} &bull; {{ $patient->gender }}, {{ $patient->age }}y &bull; Blood: {{ $patient->blood_group ?? 'N/A' }}</div>
            </div>
            @if($isRepeated)
            <span class="bg-orange-400 text-white text-sm px-3 py-1 rounded-full font-semibold">↺ Repeat Patient</span>
            @endif
        </div>
        <div class="grid grid-cols-4 gap-4 mt-4">
            <div class="bg-white bg-opacity-20 rounded-lg p-3 text-center"><div class="text-2xl font-bold">{{ $totalVisits }}</div><div class="text-xs text-blue-100">Total Visits</div></div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3 text-center"><div class="text-xl font-bold">₹{{ number_format($totalSpent) }}</div><div class="text-xs text-blue-100">Total Spent</div></div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3 text-center"><div class="text-sm font-bold">{{ $firstVisit ? $firstVisit->inspection_date->format('d M Y') : 'N/A' }}</div><div class="text-xs text-blue-100">First Visit</div></div>
            <div class="bg-white bg-opacity-20 rounded-lg p-3 text-center"><div class="text-sm font-bold">{{ $lastVisit ? $lastVisit->inspection_date->format('d M Y') : 'N/A' }}</div><div class="text-xs text-blue-100">Last Visit</div></div>
        </div>
    </div>

    @if($patient->allergies)
    <div class="bg-red-50 border border-red-200 rounded-xl p-4 mb-4">
        <span class="font-semibold text-red-700"><i class="fas fa-exclamation-triangle mr-1"></i>Allergies: </span>
        <span class="text-red-600">{{ $patient->allergies }}</span>
    </div>
    @endif

    <!-- Diagnoses -->
    @if($diagnosisList->count() > 0)
    <div class="bg-white rounded-xl shadow-sm p-5 mb-4">
        <h3 class="font-semibold text-gray-700 mb-3"><i class="fas fa-clipboard-list text-blue-500 mr-2"></i>Diagnoses History</h3>
        <div class="flex flex-wrap gap-2">
            @foreach($diagnosisList as $d)
            <span class="bg-blue-50 text-blue-700 text-sm px-3 py-1 rounded-full">{{ $d }}</span>
            @endforeach
        </div>
    </div>
    @endif

    <!-- Inspection History -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
        <h3 class="font-semibold text-gray-700 mb-4"><i class="fas fa-stethoscope text-green-500 mr-2"></i>All Inspections</h3>
        @foreach($patient->inspections->sortByDesc('inspection_date') as $insp)
        <div class="border border-gray-100 rounded-xl p-4 mb-3">
            <div class="flex justify-between mb-2">
                <div class="font-semibold text-gray-800">{{ $insp->diagnosis }}</div>
                <div class="text-xs text-gray-400">{{ $insp->inspection_date->format('d M Y') }}</div>
            </div>
            <div class="text-sm text-gray-500 mb-2">Dr. {{ $insp->doctor->name ?? 'N/A' }} &bull; Complaint: {{ $insp->chief_complaint }}</div>
            @if($insp->vitals_bp)
            <div class="flex space-x-2 text-xs">
                @if($insp->vitals_bp)<span class="bg-blue-50 text-blue-600 px-2 py-0.5 rounded">BP: {{ $insp->vitals_bp }}</span>@endif
                @if($insp->vitals_temp)<span class="bg-orange-50 text-orange-600 px-2 py-0.5 rounded">Temp: {{ $insp->vitals_temp }}</span>@endif
                @if($insp->vitals_pulse)<span class="bg-red-50 text-red-600 px-2 py-0.5 rounded">Pulse: {{ $insp->vitals_pulse }}</span>@endif
            </div>
            @endif
            @if($insp->medicines->count() > 0)
            <div class="mt-2 flex flex-wrap gap-1">
                @foreach($insp->medicines as $med)
                <span class="text-xs bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full">{{ $med->name }} ({{ $med->pivot->dosage }})</span>
                @endforeach
            </div>
            @endif
        </div>
        @endforeach
    </div>

    <!-- Bills -->
    <div class="bg-white rounded-xl shadow-sm p-6">
        <h3 class="font-semibold text-gray-700 mb-4"><i class="fas fa-file-invoice-dollar text-green-500 mr-2"></i>Bill History</h3>
        @foreach($patient->bills->sortByDesc('bill_date') as $bill)
        <div class="flex justify-between items-center py-2 border-b last:border-0">
            <div><div class="font-medium text-sm">{{ $bill->bill_number }}</div><div class="text-xs text-gray-400">{{ $bill->bill_date->format('d M Y') }}</div></div>
            <div class="text-right">
                <div class="font-bold">₹{{ number_format($bill->total_amount) }}</div>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $bill->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">{{ ucfirst($bill->payment_status) }}</span>
            </div>
        </div>
        @endforeach
    </div>
</div>
@endsection
