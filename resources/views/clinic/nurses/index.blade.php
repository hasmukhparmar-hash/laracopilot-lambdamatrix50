@extends('layouts.clinic')
@section('title','Nurses')
@section('page-title','Nurses')
@section('breadcrumb','Home / Nurses')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Registered nurses with module permissions</p>
        @if(session('clinic_role') === 'admin')
        <a href="{{ route('nurses.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center space-x-2">
            <i class="fas fa-plus"></i><span>Add Nurse</span>
        </a>
        @endif
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Nurse</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Shift</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Department</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Permissions</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($nurses as $nurse)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 bg-pink-100 rounded-full flex items-center justify-center font-bold text-pink-600">{{ strtoupper(substr($nurse->name, 0, 1)) }}</div>
                            <div>
                                <div class="font-medium text-sm text-gray-800">{{ $nurse->name }}</div>
                                <div class="text-xs text-gray-400">{{ $nurse->phone }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3"><span class="text-xs bg-blue-100 text-blue-700 px-2 py-0.5 rounded-full">{{ $nurse->shift }}</span></td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $nurse->department ?? '—' }}</td>
                    <td class="px-4 py-3">
                        <div class="flex flex-wrap gap-1">
                            @if($nurse->permissions)
                                @foreach($nurse->permissions as $perm)
                                <span class="text-xs bg-purple-100 text-purple-700 px-1.5 py-0.5 rounded">{{ str_replace('_', ' ', $perm) }}</span>
                                @endforeach
                            @else
                                <span class="text-xs text-gray-300">No permissions</span>
                            @endif
                        </div>
                    </td>
                    <td class="px-4 py-3"><span class="text-xs px-2 py-0.5 rounded-full {{ $nurse->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $nurse->active ? 'Active' : 'Inactive' }}</span></td>
                    <td class="px-4 py-3 text-right">
                        @if(session('clinic_role') === 'admin')
                        <div class="flex justify-end space-x-1">
                            <a href="{{ route('nurses.edit', $nurse->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit text-sm"></i></a>
                            <form action="{{ route('nurses.destroy', $nurse->id) }}" method="POST" class="inline">@csrf @method('DELETE')
                                <button onclick="return confirm('Remove nurse?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash text-sm"></i></button>
                            </form>
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400">No nurses added.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $nurses->links() }}</div>
    </div>
</div>
@endsection
