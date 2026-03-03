@extends('layouts.admin')
@section('title', 'Floors')
@section('page-title', 'Floor Management')
@section('breadcrumb', 'Home / Floors')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <div>
            <p class="text-gray-500 text-sm">Manage all floors and their room details</p>
        </div>
        <a href="{{ route('admin.floors.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center space-x-2">
            <i class="fas fa-plus"></i><span>Add Floor</span>
        </a>
    </div>

    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($floors as $floor)
        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition p-6 border border-gray-100">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-xl flex items-center justify-center">
                        <span class="text-white font-bold text-lg">{{ $floor->floor_number }}</span>
                    </div>
                    <div>
                        <h3 class="font-semibold text-gray-800">{{ $floor->floor_name }}</h3>
                        <p class="text-xs text-gray-400">{{ $floor->total_rooms }} total rooms</p>
                    </div>
                </div>
                <div class="flex space-x-1">
                    <a href="{{ route('admin.floors.show', $floor->id) }}" class="p-1.5 text-teal-600 hover:bg-teal-50 rounded" title="View"><i class="fas fa-eye text-sm"></i></a>
                    <a href="{{ route('admin.floors.edit', $floor->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="Edit"><i class="fas fa-edit text-sm"></i></a>
                    <form action="{{ route('admin.floors.destroy', $floor->id) }}" method="POST" class="inline">
                        @csrf @method('DELETE')
                        <button type="submit" onclick="return confirm('Delete this floor?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash text-sm"></i></button>
                    </form>
                </div>
            </div>
            @if($floor->description)
            <p class="text-sm text-gray-500 mb-4">{{ $floor->description }}</p>
            @endif
            <div class="grid grid-cols-3 gap-2 text-center">
                <div class="bg-gray-50 rounded-lg p-2">
                    <div class="font-semibold text-gray-700">{{ $floor->rooms_count }}</div>
                    <div class="text-xs text-gray-400">Rooms</div>
                </div>
                <div class="bg-green-50 rounded-lg p-2">
                    <div class="font-semibold text-green-700">{{ $floor->occupied_count }}</div>
                    <div class="text-xs text-gray-400">Occupied</div>
                </div>
                <div class="bg-blue-50 rounded-lg p-2">
                    <div class="font-semibold text-blue-700">{{ $floor->vacant_count }}</div>
                    <div class="text-xs text-gray-400">Vacant</div>
                </div>
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-16 bg-white rounded-xl">
            <i class="fas fa-layer-group text-5xl text-gray-200 mb-4"></i>
            <p class="text-gray-400">No floors added yet.</p>
            <a href="{{ route('admin.floors.create') }}" class="mt-4 inline-block bg-teal-600 text-white px-6 py-2 rounded-lg text-sm">Add First Floor</a>
        </div>
        @endforelse
    </div>
</div>
@endsection
