@extends('layouts.admin')
@section('title', 'Residents')
@section('page-title', 'Residents')
@section('breadcrumb', 'Home / Residents')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Manage all society residents</p>
        <a href="{{ route('admin.residents.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center space-x-2">
            <i class="fas fa-plus"></i><span>Add Resident</span>
        </a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Resident</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Room / Floor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Contact</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Members</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Move In</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($residents as $r)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 bg-teal-100 rounded-full flex items-center justify-center font-semibold text-teal-700">{{ strtoupper(substr($r->name,0,1)) }}</div>
                            <div><div class="font-medium text-sm text-gray-800">{{ $r->name }}</div><div class="text-xs text-gray-400">{{ $r->email }}</div></div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <div class="font-medium">Room {{ $r->room->room_number ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-400">{{ $r->room->floor->floor_name ?? '' }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $r->phone }}</td>
                    <td class="px-4 py-3 text-sm text-center"><span class="bg-gray-100 text-gray-700 px-2 py-0.5 rounded-full">{{ $r->members_count }}</span></td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $r->move_in_date->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $r->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($r->status) }}</span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end space-x-1">
                            <a href="{{ route('admin.residents.show', $r->id) }}" class="p-1.5 text-teal-600 hover:bg-teal-50 rounded"><i class="fas fa-eye text-sm"></i></a>
                            <a href="{{ route('admin.residents.edit', $r->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit text-sm"></i></a>
                            <form action="{{ route('admin.residents.destroy', $r->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Remove this resident?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash text-sm"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No residents found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $residents->links() }}</div>
    </div>
</div>
@endsection
