@extends('layouts.clinic')
@section('title','Income Report')
@section('page-title','Income Report')
@section('breadcrumb','Home / Reports / Income')

@section('content')
<div class="py-4">
    <div class="bg-white rounded-xl shadow-sm p-4 mb-6">
        <form method="GET" class="flex items-end space-x-4">
            <div>
                <label class="block text-sm font-medium text-gray-700 mb-1">Year</label>
                <select name="year" class="border border-gray-300 rounded-lg px-3 py-2 focus:ring-2 focus:ring-blue-400 outline-none">
                    @foreach(range(date('Y')-3, date('Y')) as $y)
                    <option value="{{ $y }}" {{ $year == $y ? 'selected' : '' }}>{{ $y }}</option>
                    @endforeach
                </select>
            </div>
            <button type="submit" class="bg-blue-600 text-white px-6 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-search mr-2"></i>Generate</button>
        </form>
    </div>

    <div class="grid grid-cols-2 gap-4 mb-6">
        <div class="bg-green-50 border border-green-200 rounded-xl p-5">
            <div class="text-xs text-gray-500 uppercase font-semibold">Total Income {{ $year }}</div>
            <div class="text-3xl font-bold text-green-700 mt-1">₹{{ number_format($yearTotal) }}</div>
        </div>
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-5">
            <div class="text-xs text-gray-500 uppercase font-semibold">Total Pending {{ $year }}</div>
            <div class="text-3xl font-bold text-orange-700 mt-1">₹{{ number_format($yearPending) }}</div>
        </div>
    </div>

    <!-- Bar Chart -->
    <div class="bg-white rounded-xl shadow-sm p-6 mb-6">
        <h3 class="font-semibold text-gray-700 mb-4">Monthly Income Chart — {{ $year }}</h3>
        @php $maxVal = max(array_column($monthlyData, 'income')) ?: 1; @endphp
        <div class="flex items-end space-x-2 h-48">
            @foreach($monthlyData as $m => $data)
            <div class="flex-1 flex flex-col items-center">
                <div class="text-xs text-gray-400 mb-1">{{ $data['income'] > 0 ? '₹'.number_format($data['income']/1000).'k' : '' }}</div>
                <div class="w-full rounded-t-lg bg-gradient-to-t from-blue-600 to-blue-400 transition-all"
                    style="height: {{ max(4, ($data['income']/$maxVal)*160) }}px"
                    title="₹{{ number_format($data['income']) }}"></div>
                <div class="text-xs text-gray-500 mt-1">{{ date('M', mktime(0,0,0,$m,1)) }}</div>
            </div>
            @endforeach
        </div>
    </div>

    <!-- Monthly Table -->
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Month</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Patients</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Inspections</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Income (Paid)</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Pending</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($monthlyData as $m => $data)
                <tr class="hover:bg-gray-50 {{ $m == date('n') ? 'bg-blue-50' : '' }}">
                    <td class="px-4 py-3 font-medium text-sm">{{ date('F', mktime(0,0,0,$m,1)) }} {{ $year }}</td>
                    <td class="px-4 py-3 text-sm">{{ $data['patients'] }}</td>
                    <td class="px-4 py-3 text-sm">{{ $data['inspections'] }}</td>
                    <td class="px-4 py-3 font-semibold text-green-700">₹{{ number_format($data['income']) }}</td>
                    <td class="px-4 py-3 font-semibold text-orange-600">₹{{ number_format($data['pending']) }}</td>
                </tr>
                @endforeach
            </tbody>
            <tfoot class="bg-gray-50">
                <tr>
                    <td class="px-4 py-3 font-bold" colspan="3">TOTAL {{ $year }}</td>
                    <td class="px-4 py-3 font-bold text-green-700 text-lg">₹{{ number_format($yearTotal) }}</td>
                    <td class="px-4 py-3 font-bold text-orange-600">₹{{ number_format($yearPending) }}</td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
@endsection
