@extends('layouts.admin')
@section('title', 'Visitors')
@section('page-title', 'Visitor Log')
@section('breadcrumb', 'Home / Visitors')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Track all visitor entries and exits</p>
        <a href="{{ route('admin.visitors.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center space-x-2">
            <i class="fas fa-plus"></i><span>Log Visitor</span>
        </a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Visitor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Visiting</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Purpose</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Check In</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Check Out</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($visitors as $v)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="font-medium text-sm text-gray-800">{{ $v->visitor_name }}</div>
                        <div class="text-xs text-gray-400">{{ $v->visitor_phone }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm">
                        <div>{{ $v->resident->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-400">Room {{ $v->resident->room->room_number ?? '' }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $v->purpose }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $v->visit_date->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-sm text-green-600 font-medium">{{ $v->check_in }}</td>
                    <td class="px-4 py-3 text-sm text-gray-500">{{ $v->check_out ?? '<span class="text-orange-400">Still inside</span>' }}</td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end space-x-1">
                            <a href="{{ route('admin.visitors.edit', $v->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit text-sm"></i></a>
                            <form action="{{ route('admin.visitors.destroy', $v->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button type="submit" onclick="return confirm('Delete visitor log?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash text-sm"></i></button>
                            </form>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No visitor records.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $visitors->links() }}</div>
    </div>
</div>
@endsection
