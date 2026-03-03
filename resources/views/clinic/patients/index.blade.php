@extends('layouts.clinic')
@section('title','Patients')
@section('page-title','Patient Management')
@section('breadcrumb','Home / Patients')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">All registered patients</p>
        <a href="{{ route('patients.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center space-x-2 transition">
            <i class="fas fa-plus"></i><span>Register Patient</span>
        </a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Patient</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">ID</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Age/Gender</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Contact</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Visits</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Blood</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($patients as $p)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center font-bold text-blue-700">{{ strtoupper(substr($p->name,0,1)) }}</div>
                            <div>
                                <div class="font-medium text-sm text-gray-800">{{ $p->name }}</div>
                                @if($p->inspections_count > 1)<span class="text-xs bg-orange-100 text-orange-700 px-1.5 py-0.5 rounded-full">↺ Repeat</span>@endif
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3 text-xs font-mono text-gray-600">{{ $p->patient_id }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $p->age }}y / {{ $p->gender }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $p->phone }}</td>
                    <td class="px-4 py-3"><span class="bg-blue-100 text-blue-700 text-xs px-2 py-0.5 rounded-full font-medium">{{ $p->inspections_count }} visits</span></td>
                    <td class="px-4 py-3"><span class="bg-red-100 text-red-700 text-xs px-2 py-0.5 rounded-full font-bold">{{ $p->blood_group ?? 'N/A' }}</span></td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end space-x-1">
                            <a href="{{ route('patients.show', $p->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded" title="View"><i class="fas fa-eye text-sm"></i></a>
                            <a href="{{ route('patients.edit', $p->id) }}" class="p-1.5 text-green-600 hover:bg-green-50 rounded" title="Edit"><i class="fas fa-edit text-sm"></i></a>
                            <a href="{{ route('reports.patient', $p->id) }}" class="p-1.5 text-purple-600 hover:bg-purple-50 rounded" title="Report"><i class="fas fa-chart-line text-sm"></i></a>
                            @if(session('clinic_role') === 'admin')
                            <form action="{{ route('patients.destroy', $p->id) }}" method="POST" class="inline">
                                @csrf @method('DELETE')
                                <button onclick="return confirm('Delete patient?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash text-sm"></i></button>
                            </form>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No patients registered.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $patients->links() }}</div>
    </div>
</div>
@endsection
