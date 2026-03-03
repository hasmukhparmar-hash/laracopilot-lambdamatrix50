@extends('layouts.clinic')
@section('title','Inspections')
@section('page-title','Patient Inspections')
@section('breadcrumb','Home / Inspections')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">All patient inspection records</p>
        @if(session('clinic_role') !== 'nurse' || in_array('create_inspection', session('nurse_permissions', [])))
        <a href="{{ route('inspections.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center space-x-2 transition">
            <i class="fas fa-plus"></i><span>New Inspection</span>
        </a>
        @endif
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Patient</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Doctor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Diagnosis</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Follow-up</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($inspections as $i)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="font-medium text-sm text-gray-800">{{ $i->patient->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-400">{{ $i->patient->patient_id ?? '' }}</div>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $i->doctor->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $i->inspection_date->format('d M Y') }}</td>
                    <td class="px-4 py-3">
                        <div class="text-sm font-medium text-gray-800 max-w-xs truncate">{{ $i->diagnosis }}</div>
                        <div class="text-xs text-gray-400 truncate">{{ Str::limit($i->chief_complaint, 50) }}</div>
                    </td>
                    <td class="px-4 py-3">
                        @if($i->follow_up_date)
                            <span class="text-xs {{ $i->follow_up_date->isPast() ? 'text-red-600 font-semibold' : 'text-blue-600' }}">
                                {{ $i->follow_up_date->format('d M Y') }}
                            </span>
                        @else<span class="text-gray-300 text-xs">—</span>@endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end space-x-1">
                            <a href="{{ route('inspections.show', $i->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-eye text-sm"></i></a>
                            <a href="{{ route('inspections.edit', $i->id) }}" class="p-1.5 text-green-600 hover:bg-green-50 rounded"><i class="fas fa-edit text-sm"></i></a>
                            @if(session('clinic_role') === 'admin')
                            <form action="{{ route('inspections.destroy', $i->id) }}" method="POST" class="inline">@csrf @method('DELETE')
                                <button onclick="return confirm('Delete?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash text-sm"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400">No inspections found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $inspections->links() }}</div>
    </div>
</div>
@endsection
