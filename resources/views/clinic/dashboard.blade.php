@extends('layouts.clinic')
@section('title','Dashboard')
@section('page-title','Dashboard')
@section('breadcrumb','Home / Dashboard')

@section('content')
<div class="py-4">
    <!-- Welcome -->
    <div class="mb-6 bg-gradient-to-r from-blue-600 to-indigo-700 rounded-2xl p-6 text-white">
        <div class="flex items-center justify-between">
            <div>
                <h2 class="text-2xl font-bold">Welcome, {{ session('clinic_user') }}! 👋</h2>
                <p class="text-blue-100 mt-1">Here's your clinic overview for today, {{ date('d F Y') }}</p>
            </div>
            <div class="text-right">
                <div class="text-3xl font-bold">{{ $todayPatients }}</div>
                <div class="text-blue-200 text-sm">Patients Today</div>
            </div>
        </div>
    </div>

    <!-- KPI Cards -->
    <div class="grid grid-cols-2 lg:grid-cols-4 gap-4 mb-6">
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-blue-500">
            <div class="flex justify-between items-center">
                <div><div class="text-xs text-gray-500 uppercase font-semibold">Total Patients</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $totalPatients }}</div></div>
                <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center"><i class="fas fa-user-injured text-blue-600"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-green-500">
            <div class="flex justify-between items-center">
                <div><div class="text-xs text-gray-500 uppercase font-semibold">Today Inspections</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $todayInspections }}</div></div>
                <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center"><i class="fas fa-stethoscope text-green-600"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-emerald-500">
            <div class="flex justify-between items-center">
                <div><div class="text-xs text-gray-500 uppercase font-semibold">This Month Income</div><div class="text-2xl font-bold text-gray-800 mt-1">₹{{ number_format($thisMonthBills) }}</div></div>
                <div class="w-12 h-12 bg-emerald-100 rounded-full flex items-center justify-center"><i class="fas fa-rupee-sign text-emerald-600"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-{{ $lowStockCount > 0 ? 'red' : 'gray' }}-500">
            <div class="flex justify-between items-center">
                <div><div class="text-xs text-gray-500 uppercase font-semibold">Low Stock Meds</div><div class="text-3xl font-bold text-{{ $lowStockCount > 0 ? 'red' : 'gray' }}-600 mt-1">{{ $lowStockCount }}</div></div>
                <div class="w-12 h-12 bg-{{ $lowStockCount > 0 ? 'red' : 'gray' }}-100 rounded-full flex items-center justify-center"><i class="fas fa-pills text-{{ $lowStockCount > 0 ? 'red' : 'gray' }}-600"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-purple-500">
            <div class="flex justify-between items-center">
                <div><div class="text-xs text-gray-500 uppercase font-semibold">Total Doctors</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $totalDoctors }}</div></div>
                <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center"><i class="fas fa-user-md text-purple-600"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-pink-500">
            <div class="flex justify-between items-center">
                <div><div class="text-xs text-gray-500 uppercase font-semibold">Nurses</div><div class="text-3xl font-bold text-gray-800 mt-1">{{ $totalNurses }}</div></div>
                <div class="w-12 h-12 bg-pink-100 rounded-full flex items-center justify-center"><i class="fas fa-user-nurse text-pink-600"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-orange-500">
            <div class="flex justify-between items-center">
                <div><div class="text-xs text-gray-500 uppercase font-semibold">Pending Bills</div><div class="text-3xl font-bold text-orange-600 mt-1">{{ $pendingBills }}</div></div>
                <div class="w-12 h-12 bg-orange-100 rounded-full flex items-center justify-center"><i class="fas fa-file-invoice-dollar text-orange-600"></i></div>
            </div>
        </div>
        <div class="bg-white rounded-xl shadow-sm p-5 border-l-4 border-teal-500">
            <div class="flex justify-between items-center">
                <div><div class="text-xs text-gray-500 uppercase font-semibold">Repeat Patients</div><div class="text-3xl font-bold text-teal-600 mt-1">{{ $repeatedPatients }}</div></div>
                <div class="w-12 h-12 bg-teal-100 rounded-full flex items-center justify-center"><i class="fas fa-redo text-teal-600"></i></div>
            </div>
        </div>
    </div>

    <!-- Monthly Chart + Recent Patients -->
    <div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-6">
        <!-- Monthly Income Chart -->
        <div class="lg:col-span-2 bg-white rounded-xl shadow-sm p-6">
            <h3 class="font-semibold text-gray-700 mb-4">Monthly Income ({{ date('Y') }})</h3>
            <div class="flex items-end space-x-2 h-40">
                @php $maxIncome = max(array_values($monthlyIncome)) ?: 1; $months = ['J','F','M','A','M','J','J','A','S','O','N','D']; @endphp
                @foreach($monthlyIncome as $m => $income)
                <div class="flex-1 flex flex-col items-center">
                    <div class="text-xs text-gray-400 mb-1">{{ $income > 0 ? '₹'.number_format($income/1000).'k' : '' }}</div>
                    <div class="w-full rounded-t-lg bg-gradient-to-t from-blue-500 to-blue-400 transition-all"
                        style="height: {{ max(4, ($income/$maxIncome)*120) }}px"
                        title="₹{{ number_format($income) }}"></div>
                    <div class="text-xs text-gray-500 mt-1">{{ $months[$m-1] }}</div>
                </div>
                @endforeach
            </div>
        </div>

        <!-- Recent Patients -->
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-gray-700">Recent Patients</h3>
                <a href="{{ route('patients.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($recentPatients as $p)
                <a href="{{ route('patients.show', $p->id) }}" class="flex items-center space-x-3 p-2 hover:bg-gray-50 rounded-lg">
                    <div class="w-9 h-9 bg-blue-100 rounded-full flex items-center justify-center font-bold text-blue-700 text-sm">{{ strtoupper(substr($p->name,0,1)) }}</div>
                    <div class="flex-1 min-w-0">
                        <div class="text-sm font-medium text-gray-800 truncate">{{ $p->name }}</div>
                        <div class="text-xs text-gray-400">{{ $p->gender }}, {{ $p->age }}y &bull; {{ $p->phone }}</div>
                    </div>
                    @if($p->inspections_count > 1)<span class="text-xs bg-orange-100 text-orange-700 px-1.5 py-0.5 rounded-full">↺</span>@endif
                </a>
                @empty<p class="text-gray-400 text-sm text-center py-4">No patients yet.</p>@endforelse
            </div>
        </div>
    </div>

    <!-- Recent Inspections + Low Stock -->
    <div class="grid grid-cols-1 lg:grid-cols-2 gap-6">
        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-gray-700">Recent Inspections</h3>
                <a href="{{ route('inspections.index') }}" class="text-sm text-blue-600 hover:underline">View all</a>
            </div>
            <div class="space-y-3">
                @forelse($recentInspections as $i)
                <div class="flex items-start justify-between p-2 hover:bg-gray-50 rounded-lg">
                    <div class="flex items-start space-x-3">
                        <div class="w-8 h-8 bg-green-100 rounded-full flex items-center justify-center"><i class="fas fa-stethoscope text-green-600 text-xs"></i></div>
                        <div>
                            <div class="text-sm font-medium">{{ $i->patient->name ?? 'N/A' }}</div>
                            <div class="text-xs text-gray-400">{{ $i->diagnosis }} &bull; Dr. {{ $i->doctor->name ?? '' }}</div>
                        </div>
                    </div>
                    <div class="text-xs text-gray-400">{{ $i->inspection_date->format('d M') }}</div>
                </div>
                @empty<p class="text-gray-400 text-sm text-center py-4">No inspections.</p>@endforelse
            </div>
        </div>

        <div class="bg-white rounded-xl shadow-sm p-6">
            <div class="flex justify-between items-center mb-4">
                <h3 class="font-semibold text-gray-700">Low Stock Alert</h3>
                <a href="{{ route('stock.index') }}" class="text-sm text-blue-600 hover:underline">Manage Stock</a>
            </div>
            @if($lowStockMedicines->isEmpty())
                <div class="text-center py-8"><i class="fas fa-check-circle text-3xl text-green-400 mb-2"></i><p class="text-gray-400 text-sm">All medicines well stocked!</p></div>
            @else
            <div class="space-y-3">
                @foreach($lowStockMedicines as $stock)
                <div class="flex items-center justify-between p-3 bg-red-50 rounded-lg border border-red-100">
                    <div>
                        <div class="text-sm font-medium text-gray-800">{{ $stock->medicine->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-500">{{ $stock->medicine->category ?? '' }}</div>
                    </div>
                    <div class="text-right">
                        <div class="font-bold text-red-600">{{ $stock->quantity }}</div>
                        <div class="text-xs text-gray-400">remaining</div>
                    </div>
                </div>
                @endforeach
            </div>
            @endif
        </div>
    </div>
</div>
@endsection
