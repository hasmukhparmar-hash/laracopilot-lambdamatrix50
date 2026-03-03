@extends('layouts.clinic')
@section('title','Repeated Patients')
@section('page-title','Repeated Patients')
@section('breadcrumb','Home / Reports / Repeated')

@section('content')
<div class="py-4">
    <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 mb-6">
        <i class="fas fa-info-circle text-orange-600 mr-2"></i>
        <span class="text-sm text-orange-700">Patients who have visited the clinic more than once, sorted by most visits.</span>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">#</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Patient</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Total Visits</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Blood Group</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Phone</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($patients as $i => $p)
                <tr class="hover:bg-orange-50">
                    <td class="px-4 py-3 text-sm font-bold text-gray-400">{{ $i + 1 }}</td>
                    <td class="px-4 py-3">
                        <div class="flex items-center space-x-3">
                            <div class="w-9 h-9 bg-orange-100 rounded-full flex items-center justify-center font-bold text-orange-600">{{ strtoupper(substr($p->name,0,1)) }}</div>
                            <div>
                                <div class="font-medium text-sm text-gray-800">{{ $p->name }}</div>
                                <div class="text-xs text-gray-400">{{ $p->patient_id }}</div>
                            </div>
                        </div>
                    </td>
                    <td class="px-4 py-3">
                        <span class="text-lg font-bold text-orange-600">{{ $p->inspections_count }}</span>
                        <span class="text-xs text-gray-400 ml-1">visits</span>
                    </td>
                    <td class="px-4 py-3"><span class="bg-red-100 text-red-700 text-xs px-2 py-0.5 rounded-full font-bold">{{ $p->blood_group ?? 'N/A' }}</span></td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $p->phone }}</td>
                    <td class="px-4 py-3">
                        <div class="flex space-x-1">
                            <a href="{{ route('patients.show', $p->id) }}" class="text-xs bg-blue-600 text-white px-3 py-1 rounded-lg hover:bg-blue-700">View</a>
                            <a href="{{ route('reports.patient', $p->id) }}" class="text-xs bg-purple-600 text-white px-3 py-1 rounded-lg hover:bg-purple-700">Report</a>
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="6" class="text-center py-12 text-gray-400">No repeated patients found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $patients->links() }}</div>
    </div>
</div>
@endsection
