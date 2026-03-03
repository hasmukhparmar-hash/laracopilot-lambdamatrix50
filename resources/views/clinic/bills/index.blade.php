@extends('layouts.clinic')
@section('title','Bills')
@section('page-title','Bills & Payments')
@section('breadcrumb','Home / Bills')

@section('content')
<div class="py-4">
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-green-50 border border-green-100 rounded-xl p-4">
            <div class="text-xs text-gray-500 uppercase font-semibold">Total Revenue</div>
            <div class="text-2xl font-bold text-green-700 mt-1">₹{{ number_format($totalRevenue) }}</div>
        </div>
        <div class="bg-orange-50 border border-orange-100 rounded-xl p-4">
            <div class="text-xs text-gray-500 uppercase font-semibold">Pending Amount</div>
            <div class="text-2xl font-bold text-orange-700 mt-1">₹{{ number_format($pendingAmount) }}</div>
        </div>
        <div class="bg-blue-50 border border-blue-100 rounded-xl p-4 flex items-center justify-end">
            @if(session('clinic_role') !== 'nurse')
            <a href="{{ route('bills.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center space-x-2">
                <i class="fas fa-plus"></i><span>Create Bill</span>
            </a>
            @endif
        </div>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Bill #</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Patient</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Doctor</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Date</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Amount</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($bills as $b)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3 text-xs font-mono text-gray-600">{{ $b->bill_number }}</td>
                    <td class="px-4 py-3 text-sm font-medium text-gray-800">{{ $b->patient->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $b->doctor->name ?? 'N/A' }}</td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $b->bill_date->format('d M Y') }}</td>
                    <td class="px-4 py-3 text-sm font-semibold text-gray-800">₹{{ number_format($b->total_amount) }}</td>
                    <td class="px-4 py-3">
                        <span class="text-xs px-2 py-0.5 rounded-full font-medium
                            {{ $b->payment_status === 'paid' ? 'bg-green-100 text-green-700' : ($b->payment_status === 'partial' ? 'bg-yellow-100 text-yellow-700' : 'bg-orange-100 text-orange-700') }}">
                            {{ ucfirst($b->payment_status) }}
                        </span>
                    </td>
                    <td class="px-4 py-3 text-right">
                        <div class="flex justify-end space-x-1">
                            <a href="{{ route('bills.show', $b->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-eye text-sm"></i></a>
                            <a href="{{ route('invoices.print', $b->id) }}" target="_blank" class="p-1.5 text-green-600 hover:bg-green-50 rounded"><i class="fas fa-print text-sm"></i></a>
                            @if(session('clinic_role') !== 'nurse')
                            <a href="{{ route('bills.edit', $b->id) }}" class="p-1.5 text-yellow-600 hover:bg-yellow-50 rounded"><i class="fas fa-edit text-sm"></i></a>
                            @endif
                        </div>
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No bills found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $bills->links() }}</div>
    </div>
</div>
@endsection
