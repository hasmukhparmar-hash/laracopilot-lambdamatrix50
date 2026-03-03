@extends('layouts.admin')
@section('title', 'Maintenance')
@section('page-title', 'Maintenance Requests')
@section('breadcrumb', 'Home / Maintenance')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Track and manage maintenance requests</p>
        <a href="{{ route('admin.maintenance.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center space-x-2">
            <i class="fas fa-plus"></i><span>Add Request</span>
        </a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Title</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Room</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Priority</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Assigned To</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($maintenances as $m)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3"><div class="text-sm font-medium text-gray-800">{{ $m->title }}</div><div class="text-xs text-gray-400">{{ $m->created_at->format('d M Y') }}</div></td>
                    <td class="px-4 py-3 text-sm text-gray-600">Room {{ $m->room->room_number ?? 'N/A' }}</td>
                    <td class="px-4 py-3"><span class="bg-blue-50 text-blue-700 text-xs px-2 py-0.5 rounded-full">{{ $m->category }}</span></td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                            {{ $m->priority === 'urgent' ? 'bg-red-100 text-red-700' : ($m->priority === 'high' ? 'bg-orange-100 text-orange-700' : ($m->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600')) }}">
                            {{ ucfirst($m->priority) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $m->assigned_to ?? '-' }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $m->status === 'completed' ? 'bg-green-100 text-green-700' : ($m->status === 'in_progress' ? 'bg-blue-100 text-blue-700' : ($m->status === 'cancelled' ? 'bg-gray-100 text-gray-500' : 'bg-yellow-100 text-yellow-700')) }}">
                            {{ ucfirst(str_replace('_', ' ', $m->status)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end space-x-1">
                            <a href="{{ route('admin.maintenance.edit', $m->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit text-sm"></i></a>
                            <form action="{{ route('admin.maintenance.destroy', $m->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete this record?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash text-sm"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No maintenance requests.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $maintenances->links() }}</div>
    </div>
</div>
@endsection
