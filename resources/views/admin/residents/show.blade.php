@extends('layouts.admin')
@section('title', 'Resident Profile')
@section('page-title', $resident->name)
@section('breadcrumb', 'Home / Residents / Profile')

@section('content')
<div class="py-4">
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6">
        <div class="lg:col-span-1">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <div class="text-center mb-4">
                    <div class="w-16 h-16 bg-teal-100 rounded-full flex items-center justify-center mx-auto mb-3">
                        <span class="text-2xl font-bold text-teal-600">{{ strtoupper(substr($resident->name, 0, 1)) }}</span>
                    </div>
                    <h2 class="text-lg font-bold text-gray-800">{{ $resident->name }}</h2>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $resident->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($resident->status) }}</span>
                </div>
                <div class="space-y-2 text-sm">
                    <div class="flex items-center space-x-2 text-gray-600"><i class="fas fa-phone w-4 text-teal-500"></i><span>{{ $resident->phone }}</span></div>
                    @if($resident->email)<div class="flex items-center space-x-2 text-gray-600"><i class="fas fa-envelope w-4 text-teal-500"></i><span>{{ $resident->email }}</span></div>@endif
                    <div class="flex items-center space-x-2 text-gray-600"><i class="fas fa-door-open w-4 text-teal-500"></i><span>Room {{ $resident->room->room_number ?? 'N/A' }} - {{ $resident->room->floor->floor_name ?? '' }}</span></div>
                    <div class="flex items-center space-x-2 text-gray-600"><i class="fas fa-users w-4 text-teal-500"></i><span>{{ $resident->members_count }} family member(s)</span></div>
                    <div class="flex items-center space-x-2 text-gray-600"><i class="fas fa-calendar w-4 text-teal-500"></i><span>Since {{ $resident->move_in_date->format('d M Y') }}</span></div>
                    <div class="flex items-center space-x-2 text-gray-600"><i class="fas fa-id-card w-4 text-teal-500"></i><span>{{ $resident->id_proof_type }}: {{ $resident->id_proof_number }}</span></div>
                </div>
                <div class="mt-4 flex space-x-2">
                    <a href="{{ route('admin.residents.edit', $resident->id) }}" class="flex-1 text-center bg-teal-600 text-white text-sm py-2 rounded-lg hover:bg-teal-700">Edit</a>
                </div>
            </div>
        </div>
        <div class="lg:col-span-2 space-y-4">
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-3">Complaints ({{ $resident->complaints->count() }})</h3>
                @forelse($resident->complaints->take(5) as $c)
                <div class="flex justify-between items-start py-2 border-b last:border-0">
                    <div><div class="text-sm font-medium">{{ $c->title }}</div><div class="text-xs text-gray-400">{{ $c->category }} &bull; {{ $c->created_at->format('d M Y') }}</div></div>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $c->status === 'resolved' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">{{ ucfirst($c->status) }}</span>
                </div>
                @empty<p class="text-gray-400 text-sm">No complaints.</p>@endforelse
            </div>
            <div class="bg-white rounded-xl shadow-sm p-6">
                <h3 class="font-semibold text-gray-700 mb-3">Recent Visitors ({{ $resident->visitors->count() }})</h3>
                @forelse($resident->visitors->take(5) as $v)
                <div class="flex justify-between items-center py-2 border-b last:border-0">
                    <div><div class="text-sm font-medium">{{ $v->visitor_name }}</div><div class="text-xs text-gray-400">{{ $v->purpose }} &bull; {{ $v->visit_date->format('d M Y') }}</div></div>
                    <div class="text-xs text-gray-500">{{ $v->check_in }}</div>
                </div>
                @empty<p class="text-gray-400 text-sm">No visitor records.</p>@endforelse
            </div>
        </div>
    </div>
</div>
@endsection
