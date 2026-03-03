@extends('layouts.clinic')
@section('title','Edit Inspection')
@section('page-title','Edit Inspection')
@section('breadcrumb','Home / Inspections / Edit')

@section('content')
<div class="py-4 max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('inspections.update', $inspection->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Patient</label>
                    <select name="patient_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                        @foreach($patients as $p)<option value="{{ $p->id }}" {{ $inspection->patient_id == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Doctor</label>
                    <select name="doctor_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                        @foreach($doctors as $d)<option value="{{ $d->id }}" {{ $inspection->doctor_id == $d->id ? 'selected' : '' }}>{{ $d->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Date</label>
                    <input type="date" name="inspection_date" value="{{ $inspection->inspection_date->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Follow-up Date</label>
                    <input type="date" name="follow_up_date" value="{{ $inspection->follow_up_date?->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Chief Complaint</label><input type="text" name="chief_complaint" value="{{ $inspection->chief_complaint }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Symptoms</label><input type="text" name="symptoms" value="{{ $inspection->symptoms }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis</label><textarea name="diagnosis" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">{{ $inspection->diagnosis }}</textarea></div>
            </div>
            <div class="bg-blue-50 rounded-xl p-4 mb-6">
                <h4 class="font-semibold text-blue-800 mb-3">Vitals</h4>
                <div class="grid grid-cols-2 lg:grid-cols-4 gap-3">
                    <div><label class="block text-xs font-medium text-gray-600 mb-1">BP</label><input type="text" name="vitals_bp" value="{{ $inspection->vitals_bp }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none"></div>
                    <div><label class="block text-xs font-medium text-gray-600 mb-1">Temp</label><input type="text" name="vitals_temp" value="{{ $inspection->vitals_temp }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none"></div>
                    <div><label class="block text-xs font-medium text-gray-600 mb-1">Pulse</label><input type="text" name="vitals_pulse" value="{{ $inspection->vitals_pulse }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none"></div>
                    <div><label class="block text-xs font-medium text-gray-600 mb-1">Weight</label><input type="text" name="vitals_weight" value="{{ $inspection->vitals_weight }}" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none"></div>
                </div>
            </div>
            <div class="mb-6"><label class="block text-sm font-medium text-gray-700 mb-1">Notes</label><textarea name="notes" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">{{ $inspection->notes }}</textarea></div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition"><i class="fas fa-save mr-2"></i>Update</button>
                <a href="{{ route('inspections.show', $inspection->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
