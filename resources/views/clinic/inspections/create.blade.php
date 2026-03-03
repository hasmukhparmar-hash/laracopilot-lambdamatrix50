@extends('layouts.clinic')
@section('title','New Inspection')
@section('page-title','New Patient Inspection')
@section('breadcrumb','Home / Inspections / New')

@section('content')
@php
    $medOptions = '<option value="">Select Medicine</option>';
    foreach($medicines as $med) {
        $stock = $med->stock ? $med->stock->quantity : 0;
        $medOptions .= '<option value="'.$med->id.'">'.$med->name.' ('.$med->category.') - Stock: '.$stock.'</option>';
    }
@endphp
<script>window.medicineOptions = `{!! $medOptions !!}`;</script>

<div class="py-4 max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('inspections.store') }}" method="POST">
            @csrf
            <!-- Basic Info -->
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Patient <span class="text-red-500">*</span></label>
                    <select name="patient_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $p)
                        <option value="{{ $p->id }}" {{ request('patient_id') == $p->id ? 'selected' : '' }}>{{ $p->name }} ({{ $p->patient_id }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Doctor <span class="text-red-500">*</span></label>
                    <select name="doctor_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $d)
                        <option value="{{ $d->id }}">{{ $d->name }} ({{ $d->specialization }})</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Inspection Date <span class="text-red-500">*</span></label>
                    <input type="date" name="inspection_date" value="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Follow-up Date</label>
                    <input type="date" name="follow_up_date" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Chief Complaint <span class="text-red-500">*</span></label>
                    <input type="text" name="chief_complaint" placeholder="Main reason for visit" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Symptoms</label>
                    <input type="text" name="symptoms" placeholder="Observed symptoms" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis <span class="text-red-500">*</span></label>
                    <textarea name="diagnosis" rows="2" placeholder="Clinical diagnosis" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required></textarea>
                </div>
            </div>

            <!-- Vitals -->
            <div class="bg-blue-50 rounded-xl p-4 mb-6">
                <h4 class="font-semibold text-blue-800 mb-3"><i class="fas fa-heartbeat mr-2"></i>Vitals</h4>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                    <div><label class="block text-xs font-medium text-gray-600 mb-1">Blood Pressure</label><input type="text" name="vitals_bp" placeholder="120/80" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none"></div>
                    <div><label class="block text-xs font-medium text-gray-600 mb-1">Temperature</label><input type="text" name="vitals_temp" placeholder="98.6°F" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none"></div>
                    <div><label class="block text-xs font-medium text-gray-600 mb-1">Pulse</label><input type="text" name="vitals_pulse" placeholder="72 bpm" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none"></div>
                    <div><label class="block text-xs font-medium text-gray-600 mb-1">Weight</label><input type="text" name="vitals_weight" placeholder="65 kg" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none"></div>
                </div>
            </div>

            <!-- Medicines -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-semibold text-gray-700"><i class="fas fa-pills text-purple-500 mr-2"></i>Prescribed Medicines</h4>
                    <button type="button" onclick="addMedicineRow()" class="bg-purple-600 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-purple-700">
                        <i class="fas fa-plus mr-1"></i>Add Medicine
                    </button>
                </div>
                <div class="grid grid-cols-12 gap-2 mb-1 text-xs font-semibold text-gray-500 px-2">
                    <div class="col-span-4">Medicine</div><div class="col-span-3">Dosage</div><div class="col-span-2">Duration</div><div class="col-span-2">Qty</div><div class="col-span-1"></div>
                </div>
                <div id="medicine-rows"></div>
            </div>

            <!-- Notes -->
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Additional Notes</label>
                <textarea name="notes" rows="3" placeholder="Additional observations, instructions..." class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></textarea>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition"><i class="fas fa-save mr-2"></i>Save Inspection</button>
                <a href="{{ route('inspections.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
