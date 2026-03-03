@extends('layouts.clinic')
@section('title','Add Doctor')
@section('page-title','Add Doctor')
@section('breadcrumb','Home / Doctors / Add')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('doctors.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Full Name <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name') }}" placeholder="Dr. Full Name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Specialization <span class="text-red-500">*</span></label><input type="text" name="specialization" value="{{ old('specialization') }}" placeholder="e.g. General Physician" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Phone <span class="text-red-500">*</span></label><input type="text" name="phone" value="{{ old('phone') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Email</label><input type="email" name="email" value="{{ old('email') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Qualification</label><input type="text" name="qualification" value="{{ old('qualification') }}" placeholder="e.g. MBBS, MD" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Experience (Years)</label><input type="number" name="experience_years" value="{{ old('experience_years') }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Consultation Fee (₹) <span class="text-red-500">*</span></label><input type="number" name="consultation_fee" value="{{ old('consultation_fee') }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Schedule</label><input type="text" name="schedule" value="{{ old('schedule') }}" placeholder="e.g. Mon-Sat: 9AM-5PM" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div class="col-span-2"><label class="flex items-center space-x-2 cursor-pointer"><input type="checkbox" name="active" value="1" checked class="rounded"><span class="text-sm font-medium text-gray-700">Active (visible for appointments)</span></label></div>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition"><i class="fas fa-save mr-2"></i>Add Doctor</button>
                <a href="{{ route('doctors.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
