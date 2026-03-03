@extends('layouts.admin')
@section('title', 'Edit Complaint')
@section('page-title', 'Update Complaint')
@section('breadcrumb', 'Home / Complaints / Edit')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.complaints.update', $complaint->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Resident</label>
                <select name="resident_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                    @foreach($residents as $r)
                    <option value="{{ $r->id }}" {{ old('resident_id', $complaint->resident_id) == $r->id ? 'selected' : '' }}>{{ $r->name }} - Room {{ $r->room->room_number ?? '' }}</option>
                    @endforeach
                </select>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Title</label>
                <input type="text" name="title" value="{{ old('title', $complaint->title) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Category</label>
                    <select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                        @foreach(['Noise','Parking','Cleanliness','Security','Water','Electricity','Neighbor','Common Area','Other'] as $c)
                        <option value="{{ $c }}" {{ old('category', $complaint->category) == $c ? 'selected' : '' }}>{{ $c }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Priority</label>
                    <select name="priority" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                        @foreach(['low','medium','high'] as $p)
                        <option value="{{ $p }}" {{ old('priority', $complaint->priority) == $p ? 'selected' : '' }}>{{ ucfirst($p) }}</option>
                        @endforeach
                    </select>
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                    <select name="status" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
                        @foreach(['pending','under_review','resolved','rejected'] as $s)
                        <option value="{{ $s }}" {{ old('status', $complaint->status) == $s ? 'selected' : '' }}>{{ ucfirst(str_replace('_',' ',$s)) }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="4" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">{{ old('description', $complaint->description) }}</textarea>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2.5 rounded-lg font-medium transition"><i class="fas fa-save mr-2"></i>Update</button>
                <a href="{{ route('admin.complaints.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
