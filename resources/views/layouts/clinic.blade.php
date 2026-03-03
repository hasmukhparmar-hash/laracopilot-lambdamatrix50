<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Dashboard') - HealthCare Clinic</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        .sidebar-item { transition: all 0.2s; }
        .sidebar-item:hover { background: rgba(255,255,255,0.12); }
        .sidebar-item.active { background: rgba(255,255,255,0.2); border-left: 4px solid white; }
        .badge-pulse { animation: pulse 2s infinite; }
        @keyframes pulse { 0%,100%{opacity:1} 50%{opacity:.6} }
    </style>
</head>
<body class="bg-gray-100 font-sans">
<div class="flex h-screen overflow-hidden">
    <!-- Sidebar -->
    <div class="w-64 bg-gradient-to-b from-blue-700 to-blue-900 text-white flex flex-col fixed h-full z-30 shadow-xl">
        <!-- Logo -->
        <div class="p-5 border-b border-blue-600">
            <div class="flex items-center space-x-3">
                <div class="w-10 h-10 bg-white bg-opacity-20 rounded-xl flex items-center justify-center">
                    <i class="fas fa-hospital text-white text-lg"></i>
                </div>
                <div>
                    <div class="font-bold text-lg leading-tight">HealthCare</div>
                    <div class="text-blue-200 text-xs">Clinic Management</div>
                </div>
            </div>
        </div>

        <!-- User -->
        <div class="px-4 py-3 bg-blue-800 border-b border-blue-600">
            <div class="flex items-center space-x-2">
                <div class="w-8 h-8 rounded-full bg-blue-500 flex items-center justify-center font-bold text-sm">
                    {{ strtoupper(substr(session('clinic_user', 'U'), 0, 1)) }}
                </div>
                <div>
                    <div class="text-sm font-semibold truncate w-36">{{ session('clinic_user') }}</div>
                    <div class="text-xs text-blue-300 capitalize">{{ session('clinic_role') }}</div>
                </div>
            </div>
        </div>

        <!-- Nav -->
        <nav class="flex-1 overflow-y-auto py-3 px-3 space-y-0.5">
            <a href="{{ route('dashboard') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('dashboard') ? 'active' : '' }}">
                <i class="fas fa-tachometer-alt w-5 text-center"></i><span>Dashboard</span>
            </a>

            <div class="text-blue-400 text-xs font-semibold uppercase px-3 pt-3 pb-1">Patients</div>
            <a href="{{ route('patients.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('patients.*') ? 'active' : '' }}">
                <i class="fas fa-user-injured w-5 text-center"></i><span>Patients</span>
            </a>
            <a href="{{ route('inspections.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('inspections.*') ? 'active' : '' }}">
                <i class="fas fa-stethoscope w-5 text-center"></i><span>Inspections</span>
            </a>

            <div class="text-blue-400 text-xs font-semibold uppercase px-3 pt-3 pb-1">Billing</div>
            <a href="{{ route('bills.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('bills.*') ? 'active' : '' }}">
                <i class="fas fa-file-invoice-dollar w-5 text-center"></i><span>Bills</span>
            </a>
            <a href="{{ route('invoices.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('invoices.*') ? 'active' : '' }}">
                <i class="fas fa-receipt w-5 text-center"></i><span>Invoices</span>
            </a>

            <div class="text-blue-400 text-xs font-semibold uppercase px-3 pt-3 pb-1">Pharmacy</div>
            <a href="{{ route('medicines.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('medicines.*') ? 'active' : '' }}">
                <i class="fas fa-pills w-5 text-center"></i><span>Medicines</span>
            </a>
            <a href="{{ route('stock.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('stock.*') ? 'active' : '' }}">
                <i class="fas fa-boxes w-5 text-center"></i><span>Stock</span>
            </a>

            @if(session('clinic_role') !== 'nurse')
            <div class="text-blue-400 text-xs font-semibold uppercase px-3 pt-3 pb-1">Reports</div>
            <a href="{{ route('reports.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('reports.*') ? 'active' : '' }}">
                <i class="fas fa-chart-bar w-5 text-center"></i><span>Reports</span>
            </a>
            @endif

            @if(session('clinic_role') === 'admin')
            <div class="text-blue-400 text-xs font-semibold uppercase px-3 pt-3 pb-1">Staff</div>
            <a href="{{ route('doctors.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('doctors.*') ? 'active' : '' }}">
                <i class="fas fa-user-md w-5 text-center"></i><span>Doctors</span>
            </a>
            <a href="{{ route('nurses.index') }}" class="sidebar-item flex items-center space-x-3 px-3 py-2.5 rounded-lg text-sm {{ request()->routeIs('nurses.*') ? 'active' : '' }}">
                <i class="fas fa-user-nurse w-5 text-center"></i><span>Nurses</span>
            </a>
            @endif
        </nav>

        <!-- Logout -->
        <div class="p-4 border-t border-blue-600">
            <form action="{{ route('logout') }}" method="POST">
                @csrf
                <button class="w-full flex items-center space-x-2 px-3 py-2 rounded-lg text-sm text-blue-200 hover:bg-blue-700 transition">
                    <i class="fas fa-sign-out-alt"></i><span>Logout</span>
                </button>
            </form>
        </div>
    </div>

    <!-- Main -->
    <div class="ml-64 flex-1 flex flex-col overflow-hidden">
        <header class="bg-white shadow-sm px-6 py-3 flex items-center justify-between">
            <div>
                <h1 class="text-lg font-semibold text-gray-700">@yield('page-title', 'Dashboard')</h1>
                <div class="text-xs text-gray-400">@yield('breadcrumb', 'Home')</div>
            </div>
            <div class="flex items-center space-x-3">
                <span class="text-xs bg-blue-100 text-blue-700 px-3 py-1 rounded-full capitalize font-medium"><i class="fas fa-shield-alt mr-1"></i>{{ session('clinic_role') }}</span>
                <div class="text-sm text-gray-500"><i class="fas fa-calendar mr-1"></i>{{ date('D, d M Y') }}</div>
            </div>
        </header>

        <div class="px-6 pt-4">
            @if(session('success'))
                <div class="bg-green-50 border border-green-300 text-green-700 px-4 py-3 rounded-lg mb-4 flex justify-between items-center">
                    <span><i class="fas fa-check-circle mr-2"></i>{{ session('success') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-green-500">&times;</button>
                </div>
            @endif
            @if(session('error'))
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4 flex justify-between items-center">
                    <span><i class="fas fa-exclamation-circle mr-2"></i>{{ session('error') }}</span>
                    <button onclick="this.parentElement.remove()" class="text-red-500">&times;</button>
                </div>
            @endif
            @if($errors->any())
                <div class="bg-red-50 border border-red-300 text-red-700 px-4 py-3 rounded-lg mb-4">
                    <ul class="list-disc ml-5 text-sm">@foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach</ul>
                </div>
            @endif
        </div>

        <main class="flex-1 overflow-y-auto px-6 pb-8">
            @yield('content')
        </main>
    </div>
</div>
<script>
function addBillItem() {
    const container = document.getElementById('bill-items');
    const count = container.children.length;
    const div = document.createElement('div');
    div.className = 'grid grid-cols-12 gap-2 mb-2 items-center';
    div.innerHTML = `
        <div class="col-span-5"><input type="text" name="items[${count}][description]" placeholder="Description" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none" required></div>
        <div class="col-span-2"><input type="number" name="items[${count}][quantity]" placeholder="Qty" min="1" value="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none" required></div>
        <div class="col-span-3"><input type="number" name="items[${count}][unit_price]" placeholder="Price" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none" required></div>
        <div class="col-span-2"><button type="button" onclick="this.closest('div.grid').remove()" class="w-full bg-red-100 text-red-600 py-2 rounded-lg text-sm hover:bg-red-200">Remove</button></div>
    `;
    container.appendChild(div);
}

function addMedicineRow() {
    const container = document.getElementById('medicine-rows');
    const count = container.children.length;
    const options = window.medicineOptions || '';
    const div = document.createElement('div');
    div.className = 'grid grid-cols-12 gap-2 mb-2 items-center border border-gray-100 rounded-lg p-2 bg-gray-50';
    div.innerHTML = `
        <div class="col-span-4"><select name="medicines[${count}][medicine_id]" class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm outline-none" required>${options}</select></div>
        <div class="col-span-3"><input type="text" name="medicines[${count}][dosage]" placeholder="Dosage e.g. 1-0-1" class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm outline-none" required></div>
        <div class="col-span-2"><input type="text" name="medicines[${count}][duration]" placeholder="Duration" class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm outline-none" required></div>
        <div class="col-span-2"><input type="number" name="medicines[${count}][quantity]" placeholder="Qty" min="1" value="1" class="w-full border border-gray-300 rounded-lg px-2 py-2 text-sm outline-none" required></div>
        <div class="col-span-1"><button type="button" onclick="this.closest('div.grid').remove()" class="w-full bg-red-100 text-red-600 py-2 rounded-lg text-xs hover:bg-red-200"><i class="fas fa-times"></i></button></div>
    `;
    container.appendChild(div);
}
</script>
</body>
</html>
