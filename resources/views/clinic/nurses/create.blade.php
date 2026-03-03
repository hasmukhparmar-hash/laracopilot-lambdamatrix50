@extends('layouts.clinic')
@section('title','Add Nurse')
@section('page-title','Add Nurse')
@section('breadcrumb','Home / Nurses / Add')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('nurses.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name') }}" placeholder="Nurse Full Name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label><input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Shift <span class="text-red-500">*</span></label><select name="shift" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"><option value="Morning">Morning</option><option value="Evening">Evening</option><option value="Night">Night</option></select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Department</label><input type="text" name="department" value="{{ old('department') }}" placeholder="e.g. General, Pediatrics" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-semibold text-gray-700 mb-3"><i class="fas fa-shield-alt text-blue-500 mr-1"></i>Module Permissions</label>
                <div class="grid grid-cols-2 gap-2">
                    @foreach(['view_patients' => 'View Patients', 'vitals' => 'Record Vitals', 'create_inspection' => 'Create Inspections', 'view_medicines' => 'View Medicines', 'manage_stock' => 'Manage Stock', 'view_bills' => 'View Bills'] as $key => $label)
                    <label class="flex items-center space-x-2 bg-gray-50 rounded-lg p-3 cursor-pointer hover:bg-blue-50">
                        <input type="checkbox" name="permissions[]" value="{{ $key }}" class="rounded text-blue-600">
                        <span class="text-sm text-gray-700">{{ $label }}</span>
                    </label>
                    @endforeach
                </div>
            </div>
            <div class="mb-6"><label class="flex items-center space-x-2 cursor-pointer"><input type="checkbox" name="active" value="1" checked class="rounded"><span class="text-sm font-medium text-gray-700">Active</span></label></div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition"><i class="fas fa-save mr-2"></i>Add Nurse</button>
                <a href="{{ route('nurses.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
