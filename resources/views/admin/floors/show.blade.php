@extends('layouts.admin')
@section('title', 'Floor Details')
@section('page-title', $floor->floor_name)
@section('breadcrumb', 'Home / Floors / ' . $floor->floor_name)

@section('content')
<div class="py-4">
    <div class="grid grid-cols-1 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-teal-500">
            <div class="text-xs text-gray-500 uppercase font-semibold">Floor Number</div>
            <div class="text-2xl font-bold text-gray-800">{{ $floor->floor_number }}</div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-blue-500">
            <div class="text-xs text-gray-500 uppercase font-semibold">Total Rooms</div>
            <div class="text-2xl font-bold text-gray-800">{{ $rooms->count() }}</div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-green-500">
            <div class="text-xs text-gray-500 uppercase font-semibold">Occupied</div>
            <div class="text-2xl font-bold text-green-700">{{ $rooms->where('status', 'occupied')->count() }}</div>
        </div>
        <div class="bg-white rounded-xl p-5 shadow-sm border-l-4 border-yellow-500">
            <div class="text-xs text-gray-500 uppercase font-semibold">Vacant</div>
            <div class="text-2xl font-bold text-yellow-700">{{ $rooms->where('status', 'vacant')->count() }}</div>
        </div>
    </div>

    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex items-center justify-between mb-4">
            <h3 class="font-semibold text-gray-700">Rooms on {{ $floor->floor_name }}</h3>
            <a href="{{ route('admin.rooms.create') }}" class="text-sm bg-teal-600 text-white px-3 py-1.5 rounded-lg hover:bg-teal-700">+ Add Room</a>
        </div>
        <div class="grid grid-cols-2 md:grid-cols-3 lg:grid-cols-4 gap-4">
            @forelse($rooms as $room)
            <a href="{{ route('admin.rooms.show', $room->id) }}" class="block border rounded-xl p-4 hover:shadow-md transition
                {{ $room->status === 'occupied' ? 'border-green-200 bg-green-50' : ($room->status === 'maintenance' ? 'border-yellow-200 bg-yellow-50' : 'border-blue-200 bg-blue-50') }}">
                <div class="flex items-center justify-between mb-2">
                    <span class="font-bold text-gray-700 text-lg">{{ $room->room_number }}</span>
                    <span class="text-xs px-2 py-0.5 rounded-full
                        {{ $room->status === 'occupied' ? 'bg-green-100 text-green-700' : ($room->status === 'maintenance' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                        {{ ucfirst($room->status) }}
                    </span>
                </div>
                <div class="text-xs text-gray-500">{{ $room->room_type }}</div>
                <div class="text-xs text-gray-400 mt-1">₹{{ number_format($room->monthly_rent) }}/mo</div>
                @if($room->residents->count() > 0)
                <div class="text-xs text-gray-600 mt-2 font-medium">
                    <i class="fas fa-user text-teal-500 mr-1"></i>{{ $room->residents->first()->name }}
                </div>
                @endif
            </a>
            @empty
            <div class="col-span-4 text-center py-8 text-gray-400">
                <i class="fas fa-door-open text-4xl mb-2"></i><br>No rooms added to this floor yet.
            </div>
            @endforelse
        </div>
    </div>
</div>
@endsection
