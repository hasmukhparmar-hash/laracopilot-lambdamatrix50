<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Admin') - Sunrise Society</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .sidebar-link:hover { background: rgba(255,255,255,0.15); }
        .sidebar-link.active { background: rgba(255,255,255,0.2); border-left: 4px solid white; }
    </style>
</head>
<body class="bg-gray-100 font-sans">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="w-64 bg-gradient-to-b from-teal-700 to-teal-900 text-white flex flex-col fixed h-full z-30" id="sidebar">
        <!-- Logo -->
        <div class="p-5 border-b border-teal-600">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-full flex items-center justify-center">
                    <i class="fas fa-building text-white text-lg"></i>
                </div>
                <div>
                    <div class="font-bold text-lg leading-tight">Sunrise</div>
                    <div class="text-teal-200 text-xs">Society Management</div>
                </div>
            </div>
        </div>
        <!-- User Info -->
        <div class="px-5 py-3 bg-teal-800 border-b border-teal-600">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 bg-teal-500 rounded-full flex items-center justify-center text-sm font-bold">
                    {{ strtoupper(substr(session('admin_user', 'A'), 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-semibold">{{ session('admin_user', 'Admin') }}</div>
                    <div class="text-teal-300 text-xs">{{ session('admin_email') }}</div>
                </div>
            </div>
        </div>
        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto py-4 px-3">
            <a href="{{ route('admin.dashboard') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg mb-1 text-sm transition {{ request()->routeIs('admin.dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt w-5"></i><span>Dashboard</span>
            </a>
            <div class="text-teal-400 text-xs font-semibold uppercase px-3 mt-4 mb-2">Property</div>
            <a href="{{ route('admin.floors.index') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg mb-1 text-sm transition {{ request()->routeIs('admin.floors.*') ? 'active' : '' }}">
                <i class="fas fa-layer-group w-5"></i><span>Floors</span>
            </a>
            <a href="{{ route('admin.rooms.index') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg mb-1 text-sm transition {{ request()->routeIs('admin.rooms.*') ? 'active' : '' }}">
                <i class="fas fa-door-open w-5"></i><span>Rooms</span>
            </a>
            <div class="text-teal-400 text-xs font-semibold uppercase px-3 mt-4 mb-2">People</div>
            <a href="{{ route('admin.residents.index') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg mb-1 text-sm transition {{ request()->routeIs('admin.residents.*') ? 'active' : '' }}">
                <i class="fas fa-users w-5"></i><span>Residents</span>
            </a>
            <a href="{{ route('admin.visitors.index') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg mb-1 text-sm transition {{ request()->routeIs('admin.visitors.*') ? 'active' : '' }}">
                <i class="fas fa-user-clock w-5"></i><span>Visitors</span>
            </a>
            <div class="text-teal-400 text-xs font-semibold uppercase px-3 mt-4 mb-2">Management</div>
            <a href="{{ route('admin.maintenance.index') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg mb-1 text-sm transition {{ request()->routeIs('admin.maintenance.*') ? 'active' : '' }}">
                <i class="fas fa-tools w-5"></i><span>Maintenance</span>
            </a>
            <a href="{{ route('admin.complaints.index') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg mb-1 text-sm transition {{ request()->routeIs('admin.complaints.*') ? 'active' : '' }}">
                <i class="fas fa-exclamation-circle w-5"></i><span>Complaints</span>
            </a>
            <a href="{{ route('admin.notices.index') }}" class="sidebar-link flex items-center space-x-3 px-3 py-2.5 rounded-lg mb-1 text-sm transition {{ request()->routeIs('admin.notices.*') ? 'active' : '' }}">
                <i class="fas fa-bullhorn w-5"></i><span>Notices</span>
            </a>
        </nav>
        <!-- Logout -->
        <div class="p-4 border-t border-teal-600">
            <form action="{{ route('admin.logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-teal-200 hover:bg-teal-600 transition">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main Content -->
    <div class="ml-64 flex-1 flex flex-col overflow-hidden">
        <!-- Topbar -->
        <header class="bg-white shadow-sm px-6 py-3 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-700">@yield('page-title', 'Dashboard')</h1>
                <div class="text-xs text-gray-400">@yield('breadcrumb', 'Home')</div>
            </div>
            <div class="flex items-center space-x-4">
                <div class="text-sm text-gray-500"><i class="fas fa-calendar mr-1"></i>{{ date('D, d M Y') }}</div>
            </div>
        </header>

        <!-- Alerts -->
        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4 flex items-center justify-between">
                    <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-500 hover:text-green-700">&times;</button>
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <i class="fas fa-exclamation-triangle mr-2"></i>
                    <ul class="list-disc ml-6 mt-1">
                        @foreach($errors->all() as $e)<li class="text-sm">{{ $e }}</li>@endforeach
                    </ul>
                </div>
            @endif
        </div>

        <!-- Page Content -->
        <main class="flex-1 overflow-y-auto px-6 pb-6">
            @yield('content')
        </main>
    </div>
</div>
</body>
</html>
