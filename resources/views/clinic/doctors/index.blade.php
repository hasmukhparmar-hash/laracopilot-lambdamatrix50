@extends('layouts.clinic')
@section('title','Doctors')
@section('page-title','Doctors')
@section('breadcrumb','Home / Doctors')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Registered doctors</p>
        @if(session('clinic_role') === 'admin')
        <a href="{{ route('doctors.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center space-x-2">
            <i class="fas fa-plus"></i><span>Add Doctor</span>
        </a>
        @endif
    </div>
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($doctors as $doc)
        <div class="bg-white rounded-xl shadow-sm p-6 border border-gray-100 hover:shadow-md transition">
            <div class="flex items-start justify-between mb-4">
                <div class="flex items-center space-x-3">
                    <div class="w-12 h-12 bg-gradient-to-br from-blue-500 to-indigo-600 rounded-full flex items-center justify-center">
                        <span class="text-white font-bold text-lg">{{ strtoupper(substr($doc->name, 4, 1)) }}</span>
                    </div>
                    <div>
                        <div class="font-semibold text-gray-800">{{ $doc->name }}</div>
                        <div class="text-xs text-blue-600">{{ $doc->specialization }}</div>
                    </div>
                </div>
                <span class="text-xs px-2 py-0.5 rounded-full {{ $doc->active ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-500' }}">{{ $doc->active ? 'Active' : 'Inactive' }}</span>
            </div>
            <div class="space-y-1 text-sm text-gray-600 mb-4">
                <div><i class="fas fa-phone w-4 text-gray-400"></i> {{ $doc->phone }}</div>
                @if($doc->email)<div><i class="fas fa-envelope w-4 text-gray-400"></i> {{ $doc->email }}</div>@endif
                @if($doc->qualification)<div><i class="fas fa-graduation-cap w-4 text-gray-400"></i> {{ $doc->qualification }}</div>@endif
                @if($doc->experience_years)<div><i class="fas fa-briefcase w-4 text-gray-400"></i> {{ $doc->experience_years }} years experience</div>@endif
            </div>
            <div class="flex justify-between items-center pt-3 border-t">
                <div class="text-sm font-semibold text-green-600">₹{{ number_format($doc->consultation_fee) }}/visit</div>
                <div class="text-xs text-gray-400">{{ $doc->inspections_count }} visits</div>
                @if(session('clinic_role') === 'admin')
                <div class="flex space-x-1">
                    <a href="{{ route('doctors.edit', $doc->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit text-sm"></i></a>
                    <form action="{{ route('doctors.destroy', $doc->id) }}" method="POST" class="inline">@csrf @method('DELETE')
                        <button onclick="return confirm('Remove doctor?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash text-sm"></i></button>
                    </form>
                </div>
                @endif
            </div>
        </div>
        @empty
        <div class="col-span-3 text-center py-16 bg-white rounded-xl"><i class="fas fa-user-md text-5xl text-gray-200 mb-4"></i><p class="text-gray-400">No doctors added.</p></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $doctors->links() }}</div>
</div>
@endsection
