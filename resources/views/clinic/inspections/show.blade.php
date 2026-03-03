@extends('layouts.clinic')
@section('title','Inspection Details')
@section('page-title','Inspection Details')
@section('breadcrumb','Home / Inspections / View')

@section('content')
<div class="py-4 max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $inspection->patient->name ?? 'N/A' }}</h2>
                <div class="text-sm text-gray-500">{{ $inspection->patient->patient_id ?? '' }} &bull; {{ $inspection->inspection_date->format('d M Y') }} &bull; Dr. {{ $inspection->doctor->name ?? 'N/A' }}</div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('inspections.edit', $inspection->id) }}" class="bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-edit mr-1"></i>Edit</a>
                <a href="{{ route('bills.create') }}?inspection_id={{ $inspection->id }}&patient_id={{ $inspection->patient_id }}" class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-700"><i class="fas fa-file-invoice-dollar mr-1"></i>Create Bill</a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-6">
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Chief Complaint</h3>
                <p class="text-gray-600 text-sm bg-gray-50 rounded-lg p-3">{{ $inspection->chief_complaint }}</p>
            </div>
            <div>
                <h3 class="font-semibold text-gray-700 mb-2">Symptoms</h3>
                <p class="text-gray-600 text-sm bg-gray-50 rounded-lg p-3">{{ $inspection->symptoms ?? '—' }}</p>
            </div>
            <div class="col-span-2">
                <h3 class="font-semibold text-gray-700 mb-2">Diagnosis</h3>
                <p class="text-gray-600 text-sm bg-blue-50 border border-blue-100 rounded-lg p-3 font-medium">{{ $inspection->diagnosis }}</p>
            </div>
        </div>

        <!-- Vitals -->
        <div class="bg-gradient-to-r from-blue-50 to-indigo-50 rounded-xl p-4 mb-6">
            <h3 class="font-semibold text-gray-700 mb-3"><i class="fas fa-heartbeat text-red-500 mr-2"></i>Vitals</h3>
            <div class="grid grid-cols-2 lg:grid-cols-4 gap-4">
                <div class="text-center bg-white rounded-lg p-3">
                    <div class="text-lg font-bold text-blue-600">{{ $inspection->vitals_bp ?? '—' }}</div>
                    <div class="text-xs text-gray-500">Blood Pressure</div>
                </div>
                <div class="text-center bg-white rounded-lg p-3">
                    <div class="text-lg font-bold text-orange-600">{{ $inspection->vitals_temp ?? '—' }}</div>
                    <div class="text-xs text-gray-500">Temperature</div>
                </div>
                <div class="text-center bg-white rounded-lg p-3">
                    <div class="text-lg font-bold text-red-600">{{ $inspection->vitals_pulse ?? '—' }}</div>
                    <div class="text-xs text-gray-500">Pulse</div>
                </div>
                <div class="text-center bg-white rounded-lg p-3">
                    <div class="text-lg font-bold text-green-600">{{ $inspection->vitals_weight ?? '—' }}</div>
                    <div class="text-xs text-gray-500">Weight</div>
                </div>
            </div>
        </div>

        <!-- Medicines -->
        @if($inspection->medicines->count() > 0)
        <div class="mb-6">
            <h3 class="font-semibold text-gray-700 mb-3"><i class="fas fa-pills text-purple-500 mr-2"></i>Prescribed Medicines</h3>
            <div class="overflow-x-auto">
                <table class="min-w-full">
                    <thead class="bg-purple-50">
                        <tr>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-purple-700">Medicine</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-purple-700">Category</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-purple-700">Dosage</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-purple-700">Duration</th>
                            <th class="px-4 py-2 text-left text-xs font-semibold text-purple-700">Qty</th>
                        </tr>
                    </thead>
                    <tbody class="divide-y divide-gray-50">
                        @foreach($inspection->medicines as $med)
                        <tr class="hover:bg-gray-50">
                            <td class="px-4 py-3 font-medium text-sm">{{ $med->name }}</td>
                            <td class="px-4 py-3 text-sm text-gray-500">{{ $med->category }}</td>
                            <td class="px-4 py-3 text-sm">{{ $med->pivot->dosage }}</td>
                            <td class="px-4 py-3 text-sm">{{ $med->pivot->duration }}</td>
                            <td class="px-4 py-3 text-sm">{{ $med->pivot->quantity }}</td>
                        </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
        @endif

        @if($inspection->notes)
        <div class="mb-4">
            <h3 class="font-semibold text-gray-700 mb-2">Notes</h3>
            <p class="text-sm text-gray-600 bg-gray-50 rounded-lg p-3">{{ $inspection->notes }}</p>
        </div>
        @endif

        @if($inspection->follow_up_date)
        <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-3">
            <i class="fas fa-calendar-check text-yellow-600 mr-2"></i>
            <span class="text-sm font-medium text-yellow-800">Follow-up Date: {{ $inspection->follow_up_date->format('d M Y') }}</span>
        </div>
        @endif
    </div>
</div>
@endsection
