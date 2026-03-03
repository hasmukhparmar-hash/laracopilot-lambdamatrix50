@extends('layouts.admin')
@section('title', 'Rooms')
@section('page-title', 'Room Management')
@section('breadcrumb', 'Home / Rooms')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">All rooms across all floors</p>
        <a href="{{ route('admin.rooms.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center space-x-2">
            <i class="fas fa-plus"></i><span>Add Room</span>
        </a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Room</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Floor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Type</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Area</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Rent</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Resident</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($rooms as $room)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 font-semibold text-gray-800">{{ $room->room_number }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $room->floor->floor_name ?? 'N/A' }}</td>
                    <td class="px-4 py-3"><span class="bg-purple-100 text-purple-700 text-xs px-2 py-0.5 rounded-full">{{ $room->room_type }}</span></td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ number_format($room->area_sqft) }} sqft</td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-700">₹{{ number_format($room->monthly_rent) }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $room->residents->first()->name ?? '<span class="text-gray-300">Vacant</span>' }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                            {{ $room->status === 'occupied' ? 'bg-green-100 text-green-700' : ($room->status === 'maintenance' ? 'bg-yellow-100 text-yellow-700' : 'bg-blue-100 text-blue-700') }}">
                            {{ ucfirst($room->status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end space-x-1">
                            <a href="{{ route('admin.rooms.show', $room->id) }}" class="p-1.5 text-teal-600 hover:bg-teal-50 rounded"><i class="fas fa-eye text-sm"></i></a>
                            <a href="{{ route('admin.rooms.edit', $room->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit text-sm"></i></a>
                            <form action="{{ route('admin.rooms.destroy', $room->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this room?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash text-sm"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-12 text-gray-400"><i class="fas fa-door-open text-4xl mb-2 block"></i>No rooms found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $rooms->links() }}</div>
    </div>
</div>
@endsection
