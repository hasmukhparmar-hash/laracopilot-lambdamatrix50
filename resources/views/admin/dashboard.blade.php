@extends('layouts.admin')
@section('title', 'Dashboard')
@section('page-title', 'Dashboard')
@section('breadcrumb', 'Home / Dashboard')

@section('content')
<div class="py-4">
    <!-- Welcome -->
    <div class="mb-6 bg-gradient-to-r from-teal-600 to-cyan-700 rounded-xl p-6 text-white">
        <h2 class="text-2xl font-bold">Welcome back, {{ session('admin_user') }}! 👋</h2>
        <p class="text-teal-100 mt-1">Here's what's happening at Sunrise Society today.</p>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-teal-500">
            <div class="flex items-center justify-between">
                <div><div class="text-gray-500 text-xs uppercase font-semibold">Total Floors</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $totalFloors }}</div></div>
                <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center"><i class="fas fa-layer-group text-teal-600 text-lg"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
            <div class="flex items-center justify-between">
                <div><div class="text-gray-500 text-xs uppercase font-semibold">Total Rooms</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $totalRooms }}</div></div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center"><i class="fas fa-door-open text-blue-600 text-lg"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
            <div class="flex items-center justify-between">
                <div><div class="text-gray-500 text-xs uppercase font-semibold">Occupied</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $occupiedRooms }}</div></div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center"><i class="fas fa-check-circle text-green-600 text-lg"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-yellow-500">
            <div class="flex items-center justify-between">
                <div><div class="text-gray-500 text-xs uppercase font-semibold">Vacant</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $vacantRooms }}</div></div>
                <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center"><i class="fas fa-door-closed text-yellow-600 text-lg"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
            <div class="flex items-center justify-between">
                <div><div class="text-gray-500 text-xs uppercase font-semibold">Residents</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $totalResidents }}</div></div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center"><i class="fas fa-users text-purple-600 text-lg"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-red-500">
            <div class="flex items-center justify-between">
                <div><div class="text-gray-500 text-xs uppercase font-semibold">Pending Complaints</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $pendingComplaints }}</div></div>
                <div class="w-12 h-12 bg-red-100 rounded-full flex items-center justify-center"><i class="fas fa-exclamation-circle text-red-600 text-lg"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-orange-500">
            <div class="flex items-center justify-between">
                <div><div class="text-gray-500 text-xs uppercase font-semibold">Maintenance Pending</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $pendingMaintenance }}</div></div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center"><i class="fas fa-tools text-orange-600 text-lg"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-cyan-500">
            <div class="flex items-center justify-between">
                <div><div class="text-gray-500 text-xs uppercase font-semibold">Today's Visitors</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $todayVisitors }}</div></div>
                <div class="w-12 h-12 bg-cyan-100 rounded-full flex items-center justify-center"><i class="fas fa-user-clock text-cyan-600 text-lg"></i></div>
            </div>
        </div>
    </div>

    <!-- Occupancy + Floor Stats -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Occupancy Rate -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Occupancy Rate</h3>
            <div class="flex items-center justify-center">
                <div class="relative w-36 h-36">
                    <svg class="w-full h-full transform -rotate-90" viewBox="0 0 100 100">
                        <circle cx="50" cy="50" r="40" stroke="#e5e7eb" stroke-width="10" fill="none"/>
                        <circle cx="50" cy="50" r="40" stroke="#0d9488" stroke-width="10" fill="none"
                            stroke-dasharray="{{ $occupancyRate * 2.51 }} 251"
                            stroke-linecap="round"/>
                    </svg>
                    <div class="absolute inset-0 flex items-center justify-center">
                        <div class="text-center">
                            <div class="text-2xl font-bold text-teal-600">{{ $occupancyRate }}%</div>
                            <div class="text-xs text-gray-400">Occupied</div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="grid grid-cols-2 gap-2 mt-4 text-center text-sm">
                <div class="bg-green-50 rounded-lg p-2"><div class="font-semibold text-green-700">{{ $occupiedRooms }}</div><div class="text-gray-500 text-xs">Occupied</div></div>
                <div class="bg-blue-50 rounded-lg p-2"><div class="font-semibold text-blue-700">{{ $vacantRooms }}</div><div class="text-gray-500 text-xs">Vacant</div></div>
            </div>
        </div>

        <!-- Floor Stats -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Floor-wise Occupancy</h3>
            <div class="space-y-3">
                @foreach($floorStats as $floor)
                <div>
                    <div class="flex justify-between text-sm mb-1">
                        <span class="text-gray-600">{{ $floor->floor_name }}</span>
                        <span class="text-gray-500">{{ $floor->occupied_rooms_count }}/{{ $floor->rooms_count }} rooms</span>
                    </div>
                    <div class="w-full bg-gray-100 rounded-full h-2.5">
                        @php $pct = $floor->rooms_count > 0 ? ($floor->occupied_rooms_count / $floor->rooms_count) * 100 : 0; @endphp
                        <div class="bg-teal-500 h-2.5 rounded-full" style="width: {{ $pct }}%"></div>
                    </div>
                </div>
                @endforeach
            </div>
        </div>
    </div>

    <!-- Recent Activity -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-6">
        <!-- Recent Residents -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-700">Recent Residents</h3>
                <a href="{{ route('admin.residents.index') }}" class="text-sm text-teal-600 hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($recentResidents as $r)
                <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                    <div class="w-9 h-9 bg-teal-100 rounded-full flex items-center justify-center font-semibold text-teal-700 text-sm">{{ strtoupper(substr($r->name, 0, 1)) }}</div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-800 truncate">{{ $r->name }}</div>
                        <div class="text-xs text-gray-400">Room {{ $r->room->room_number ?? 'N/A' }} - {{ $r->room->floor->floor_name ?? '' }}</div>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full {{ $r->status === 'active' ? 'bg-green-100 text-green-700' : 'bg-gray-100 text-gray-600' }}">{{ ucfirst($r->status) }}</span>
                </div>
                @empty
                <p class="text-gray-400 text-sm text-center py-4">No residents yet</p>
                @endforelse
            </div>
        </div>

        <!-- Recent Complaints -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-700">Recent Complaints</h3>
                <a href="{{ route('admin.complaints.index') }}" class="text-sm text-teal-600 hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($recentComplaints as $c)
                <div class="flex items-start space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 rounded-full flex items-center justify-center mt-0.5
                        {{ $c->priority === 'high' ? 'bg-red-100' : ($c->priority === 'medium' ? 'bg-yellow-100' : 'bg-gray-100') }}">
                        <i class="fas fa-exclamation text-xs {{ $c->priority === 'high' ? 'text-red-600' : ($c->priority === 'medium' ? 'text-yellow-600' : 'text-gray-500') }}"></i>
                    </div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-800 truncate">{{ $c->title }}</div>
                        <div class="text-xs text-gray-400">{{ $c->resident->name ?? 'N/A' }} &bull; {{ $c->category }}</div>
                    </div>
                    <span class="text-xs px-2 py-0.5 rounded-full whitespace-nowrap
                        {{ $c->status === 'resolved' ? 'bg-green-100 text-green-700' : ($c->status === 'pending' ? 'bg-red-100 text-red-700' : 'bg-yellow-100 text-yellow-700') }}">
                        {{ ucfirst(str_replace('_', ' ', $c->status)) }}
                    </span>
                </div>
                @empty
                <p class="text-gray-400 text-sm text-center py-4">No complaints</p>
                @endforelse
            </div>
        </div>
    </div>

    <!-- Active Notices + Visitors -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-700">Active Notices</h3>
                <a href="{{ route('admin.notices.index') }}" class="text-sm text-teal-600 hover:underline">View all</a>
            </div>
            @forelse($activeNotices as $notice)
            <div class="mb-3 p-3 bg-teal-50 border border-teal-100 rounded-lg">
                <div class="flex items-center justify-between mb-1">
                    <span class="text-sm font-semibold text-gray-700">{{ $notice->title }}</span>
                    <span class="text-xs bg-teal-100 text-teal-700 px-2 py-0.5 rounded">{{ $notice->category }}</span>
                </div>
                <p class="text-xs text-gray-500 line-clamp-2">{{ Str::limit($notice->content, 100) }}</p>
            </div>
            @empty
            <p class="text-gray-400 text-sm text-center py-4">No active notices</p>
            @endforelse
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex items-center justify-between mb-4">
                <h3 class="font-semibold text-gray-700">Recent Visitors</h3>
                <a href="{{ route('admin.visitors.index') }}" class="text-sm text-teal-600 hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($recentVisitors as $v)
                <div class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                    <div class="w-8 h-8 bg-cyan-100 rounded-full flex items-center justify-center"><i class="fas fa-user text-cyan-600 text-xs"></i></div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-800">{{ $v->visitor_name }}</div>
                        <div class="text-xs text-gray-400">Visiting {{ $v->resident->name ?? 'N/A' }} &bull; {{ $v->purpose }}</div>
                    </div>
                    <div class="text-xs text-gray-400">{{ $v->check_in }}</div>
                </div>
                @empty
                <p class="text-gray-400 text-sm text-center py-4">No visitors today</p>
                @endforelse
            </div>
        </div>
    </div>
</div>
@endsection
