@extends('layouts.admin')
@section('title', 'Edit Floor')
@section('page-title', 'Edit Floor')
@section('breadcrumb', 'Home / Floors / Edit')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('admin.floors.update', $floor->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Floor Number <span class="text-red-500">*</span></label>
                    <input type="number" name="floor_number" value="{{ old('floor_number', $floor->floor_number) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none @error('floor_number') border-red-400 @enderror">
                    @error('floor_number')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Floor Name <span class="text-red-500">*</span></label>
                    <input type="text" name="floor_name" value="{{ old('floor_name', $floor->floor_name) }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none @error('floor_name') border-red-400 @enderror">
                    @error('floor_name')<p class="text-red-500 text-xs mt-1">{{ $message }}</p>@enderror
                </div>
            </div>
            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Total Rooms <span class="text-red-500">*</span></label>
                <input type="number" name="total_rooms" value="{{ old('total_rooms', $floor->total_rooms) }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">
            </div>
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Description</label>
                <textarea name="description" rows="3" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-teal-500 outline-none">{{ old('description', $floor->description) }}</textarea>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-teal-600 hover:bg-teal-700 text-white px-6 py-2.5 rounded-lg font-medium transition">
                    <i class="fas fa-save mr-2"></i>Update Floor
                </button>
                <a href="{{ route('admin.floors.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
