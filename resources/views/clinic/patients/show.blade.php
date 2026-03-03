@extends('layouts.clinic')
@section('title', $patient->name)
@section('page-title', 'Patient Profile')
@section('breadcrumb', 'Home / Patients / ' . $patient->name)

@section('content')
<div class="py-4">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <!-- Profile Card -->
        <div class="lg:col-span-1 space-y-4">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="text-center mb-4">
                    <div class="w-20 h-20 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-3xl font-bold text-white">{{ strtoupper(substr($patient->name,0,1)) }}</span>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">{{ $patient->name }}</h2>
                    <p class="text-xs font-mono text-gray-400 mt-1">{{ $patient->patient_id }}</p>
                    @if($isRepeated)
                        <span class="inline-block mt-2 bg-orange-100 text-orange-700 text-xs px-3 py-1 rounded-full font-semibold">↺ Repeat Patient ({{ $visitCount }} visits)</span>
                    @else
                        <span class="inline-block mt-2 bg-green-100 text-green-700 text-xs px-3 py-1 rounded-full">New Patient</span>
                    @endif
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Age/Gender</span><span class="font-medium">{{ $patient->age }}y / {{ $patient->gender }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Blood Group</span><span class="font-bold text-red-600">{{ $patient->blood_group ?? 'N/A' }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Phone</span><span class="font-medium">{{ $patient->phone }}</span></div>
                    @if($patient->email)<div class="flex justify-between"><span class="text-gray-500">Email</span><span class="font-medium text-xs">{{ $patient->email }}</span></div>@endif
                    @if($patient->emergency_contact)<div class="flex justify-between"><span class="text-gray-500">Emergency</span><span class="font-medium">{{ $patient->emergency_contact }}</span></div>@endif
                    @if($patient->referred_by)<div class="flex justify-between"><span class="text-gray-500">Referred By</span><span class="font-medium">{{ $patient->referred_by }}</span></div>@endif
                </div>
                @if($patient->allergies)
                <div class="mt-4 bg-red-50 border border-red-100 rounded-lg p-3">
                    <div class="text-xs font-semibold text-red-600 mb-1"><i class="fas fa-exclamation-triangle mr-1"></i>ALLERGIES</div>
                    <p class="text-sm text-red-700">{{ $patient->allergies }}</p>
                </div>
                @endif
                @if($patient->chronic_diseases)
                <div class="mt-3 bg-yellow-50 border border-yellow-100 rounded-lg p-3">
                    <div class="text-xs font-semibold text-yellow-700 mb-1"><i class="fas fa-heartbeat mr-1"></i>CHRONIC CONDITIONS</div>
                    <p class="text-sm text-yellow-800">{{ $patient->chronic_diseases }}</p>
                </div>
                @endif

                <div class="grid grid-cols-2 gap-2 mt-4">
                    <div class="bg-blue-50 rounded-lg p-3 text-center">
                        <div class="text-2xl font-bold text-blue-700">{{ $visitCount }}</div>
                        <div class="text-xs text-gray-500">Total Visits</div>
                    </div>
                    <div class="bg-green-50 rounded-lg p-3 text-center">
                        <div class="text-xl font-bold text-green-700">₹{{ number_format($totalSpent) }}</div>
                        <div class="text-xs text-gray-500">Total Spent</div>
                    </div>
                </div>

                <div class="mt-4 flex flex-col space-y-2">
                    <a href="{{ route('patients.edit', $patient->id) }}" class="w-full text-center bg-blue-600 text-white text-sm py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-edit mr-1"></i>Edit Patient</a>
                    <a href="{{ route('inspections.create') }}?patient_id={{ $patient->id }}" class="w-full text-center bg-green-600 text-white text-sm py-2 rounded-lg hover:bg-green-700"><i class="fas fa-stethoscope mr-1"></i>New Inspection</a>
                    <a href="{{ route('reports.patient', $patient->id) }}" class="w-full text-center bg-purple-600 text-white text-sm py-2 rounded-lg hover:bg-purple-700"><i class="fas fa-chart-line mr-1"></i>Full Report</a>
                </div>
            </div>
        </div>

        <!-- History -->
        <div class="lg:col-span-2 space-y-4">
            <!-- Inspection History -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-4"><i class="fas fa-stethoscope text-green-500 mr-2"></i>Inspection History ({{ $visitCount }})</h3>
                @forelse($patient->inspections->sortByDesc('inspection_date') as $insp)
                <div class="border border-gray-100 rounded-xl p-4 mb-3 hover:border-blue-200 transition">
                    <div class="flex justify-between items-start mb-2">
                        <div>
                            <div class="font-semibold text-gray-800">{{ $insp->diagnosis }}</div>
                            <div class="text-xs text-gray-400">{{ $insp->inspection_date->format('d M Y') }} &bull; Dr. {{ $insp->doctor->name ?? 'N/A' }}</div>
                        </div>
                        <a href="{{ route('inspections.show', $insp->id) }}" class="text-xs text-blue-600 hover:underline">View</a>
                    </div>
                    <div class="text-sm text-gray-600 mb-2"><span class="font-medium">Complaint:</span> {{ $insp->chief_complaint }}</div>
                    @if($insp->vitals_bp || $insp->vitals_temp)
                    <div class="flex space-x-3 text-xs">
                        @if($insp->vitals_bp)<span class="bg-blue-50 text-blue-700 px-2 py-0.5 rounded">BP: {{ $insp->vitals_bp }}</span>@endif
                        @if($insp->vitals_temp)<span class="bg-orange-50 text-orange-700 px-2 py-0.5 rounded">Temp: {{ $insp->vitals_temp }}</span>@endif
                        @if($insp->vitals_pulse)<span class="bg-red-50 text-red-700 px-2 py-0.5 rounded">Pulse: {{ $insp->vitals_pulse }}</span>@endif
                        @if($insp->vitals_weight)<span class="bg-green-50 text-green-700 px-2 py-0.5 rounded">Wt: {{ $insp->vitals_weight }}</span>@endif
                    </div>
                    @endif
                    @if($insp->medicines->count() > 0)
                    <div class="mt-2">
                        <div class="text-xs text-gray-500 font-medium mb-1">Medicines Prescribed:</div>
                        <div class="flex flex-wrap gap-1">
                            @foreach($insp->medicines as $med)
                            <span class="text-xs bg-purple-50 text-purple-700 px-2 py-0.5 rounded-full">{{ $med->name }} ({{ $med->pivot->dosage }}, {{ $med->pivot->duration }})</span>
                            @endforeach
                        </div>
                    </div>
                    @endif
                </div>
                @empty
                <p class="text-gray-400 text-sm text-center py-4">No inspection records.</p>
                @endforelse
            </div>

            <!-- Bill History -->
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-4"><i class="fas fa-file-invoice-dollar text-blue-500 mr-2"></i>Bill History</h3>
                @forelse($patient->bills->sortByDesc('bill_date') as $bill)
                <div class="flex items-center justify-between py-2 border-b last:border-0">
                    <div>
                        <div class="font-medium text-sm">{{ $bill->bill_number }}</div>
                        <div class="text-xs text-gray-400">{{ $bill->bill_date->format('d M Y') }} &bull; {{ $bill->payment_method ?? 'N/A' }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-gray-800">₹{{ number_format($bill->total_amount) }}</div>
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $bill->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">{{ ucfirst($bill->payment_status) }}</span>
                    </div>
                </div>
                @empty
                <p class="text-gray-400 text-sm">No bills found.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
