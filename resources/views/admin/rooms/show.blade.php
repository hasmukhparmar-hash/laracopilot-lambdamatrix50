@extends('layouts.admin')
@section('title', 'Room Details')
@section('page-title', 'Room ' . $room->room_number)
@section('breadcrumb', 'Home / Rooms / ' . $room->room_number)

@section('content')
<div class="py-4">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6 mb-4">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-gradient-to-br from-teal-500 to-cyan-600 rounded-2xl flex items-center justify-center mx-auto mb-3">
                        <i class="fas fa-door-open text-white text-2xl"></i>
                    </div>
                    <h2 class="text-xl font-bold text-gray-800">Room {{ $room->room_number }}</h2>
                    <span class="text-xs px-3 py-1 rounded-full font-medium
                        {{ $room->status === 'occupied' ? 'bg-green-100 text-green-700' : ($room->status === 'maintenance' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                        {{ ucfirst($room->status) }}
                    </span>
                </div>
                <div class="space-y-3 text-sm">
                    <div class="flex justify-between"><span class="text-gray-500">Floor</span><span class="font-medium">{{ $room->floor->floor_name ?? 'N/A' }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Type</span><span class="font-medium">{{ $room->room_type }}</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Area</span><span class="font-medium">{{ number_format($room->area_sqft) }} sqft</span></div>
                    <div class="flex justify-between"><span class="text-gray-500">Monthly Rent</span><span class="font-semibold text-teal-600">₹{{ number_format($room->monthly_rent) }}</span></div>
                </div>
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('admin.rooms.edit', $room->id) }}" class="flex-1 text-center bg-teal-600 text-white text-sm py-2 rounded-lg hover:bg-teal-700">Edit Room</a>
                </div>
            </div>
        </div>
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-3">Current Residents</h3>
                @forelse($room->residents as $r)
                <div class="flex items-center justify-between p-3 bg-gray-50 rounded-lg">
                    <div class="flex items-center space-x-3">
                        <div class="w-9 h-9 bg-teal-100 rounded-full flex items-center justify-center font-bold text-teal-700">{{ strtoupper(substr($r->name,0,1)) }}</div>
                        <div><div class="font-medium text-sm">{{ $r->name }}</div><div class="text-xs text-gray-400">{{ $r->phone }}</div></div>
                    </div>
                    <a href="{{ route('admin.residents.show', $r->id) }}" class="text-teal-600 text-xs hover:underline">View</a>
                </div>
                @empty
                <p class="text-gray-400 text-sm">No residents currently assigned.</p>
                @endforelse
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-3">Maintenance History</h3>
                @forelse($room->maintenances->take(5) as $m)
                <div class="flex items-start justify-between py-2 border-b last:border-0">
                    <div><div class="text-sm font-medium">{{ $m->title }}</div><div class="text-xs text-gray-400">{{ $m->category }} &bull; {{ $m->created_at->format('d M Y') }}</div></div>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $m->status === 'completed' ? 'bg-green-100 text-green-700' : 'bg-yellow-100 text-yellow-700' }}">{{ ucfirst($m->status) }}</span>
                </div>
                @empty
                <p class="text-gray-400 text-sm">No maintenance records.</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
