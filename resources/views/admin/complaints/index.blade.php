@extends('layouts.admin')
@section('title', 'Complaints')
@section('page-title', 'Complaints')
@section('breadcrumb', 'Home / Complaints')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Manage resident complaints</p>
        <a href="{{ route('admin.complaints.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center space-x-2">
            <i class="fas fa-plus"></i><span>Add Complaint</span>
        </a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Complaint</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Resident</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Priority</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($complaints as $c)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3"><div class="text-sm font-medium text-gray-800">{{ $c->title }}</div></td>
                    <td class="px-4 py-3 text-sm text-gray-600">
                        <div>{{ $c->resident->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-400">Room {{ $c->resident->room->room_number ?? '' }}</div>
                    </td>
                    <td class="px-4 py-3"><span class="bg-indigo-50 text-indigo-700 text-xs px-2 py-0.5 rounded-full">{{ $c->category }}</span></td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full {{ $c->priority === 'high' ? 'bg-red-100 text-red-700' : ($c->priority === 'medium' ? 'bg-yellow-100 text-yellow-700' : 'bg-gray-100 text-gray-600') }}">
                            {{ ucfirst($c->priority) }}
                        </span>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full
                            {{ $c->status === 'resolved' ? 'bg-green-100 text-green-700' : ($c->status === 'pending' ? 'bg-red-100 text-red-700' : ($c->status === 'under_review' ? 'bg-blue-100 text-blue-700' : 'bg-gray-100 text-gray-600')) }}">
                            {{ ucfirst(str_replace('_', ' ', $c->status)) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-xs text-gray-500">{{ $c->created_at->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end space-x-1">
                            <a href="{{ route('admin.complaints.edit', $c->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit text-sm"></i></a>
                            <form action="{{ route('admin.complaints.destroy', $c->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash text-sm"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No complaints recorded.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $complaints->links() }}</div>
    </div>
</div>
@endsection
