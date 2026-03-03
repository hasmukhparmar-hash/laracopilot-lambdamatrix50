@extends('layouts.admin')
@section('title', 'Log Visitor')
@section('page-title', 'Log New Visitor')
@section('breadcrumb', 'Home / Visitors / Log')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.visitors.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Visiting Resident <span class="text-red-500">*</span></label>
                    <select name="resident_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                        <option value="">Select Resident</option>
                        @foreach($residents as $r)
                        <option value="{{ $r->id }}" {{ old('resident_id') == $r->id ? 'selected' : '' }}>{{ $r->name }} - Room {{ $r->room->room_number ?? '' }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Visitor Name <span class="text-red-500">*</span></label>
                    <input type="text" name="visitor_name" value="{{ old('visitor_name') }}" placeholder="Full name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label>
                    <input type="text" name="visitor_phone" value="{{ old('visitor_phone') }}" placeholder="Phone number" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Purpose <span class="text-red-500">*</span></label>
                    <input type="text" name="purpose" value="{{ old('purpose') }}" placeholder="Reason for visit" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Visit Date <span class="text-red-500">*</span></label>
                    <input type="date" name="visit_date" value="{{ old('visit_date', date('Y-m-d')) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Check In Time <span class="text-red-500">*</span></label>
                    <input type="time" name="check_in" value="{{ old('check_in', date('H:i')) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Check Out Time</label>
                    <input type="time" name="check_out" value="{{ old('check_out') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Vehicle Number</label>
                    <input type="text" name="vehicle_number" value="{{ old('vehicle_number') }}" placeholder="MH12AB1234" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">ID Proof</label>
                    <input type="text" name="id_proof" value="{{ old('id_proof') }}" placeholder="e.g. Aadhar - 1234 5678 9012" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2.5 rounded-lg font-medium transition"><i class="fas fa-save mr-2"></i>Log Visitor</button>
                <a href="{{ route('admin.visitors.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection