@extends('layouts.clinic')
@section('title','Bill Details')
@section('page-title','Bill Details')
@section('breadcrumb','Home / Bills / View')

@section('content')
<div class="py-4 max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="flex justify-between items-start mb-6">
            <div>
                <h2 class="text-xl font-bold text-gray-800">{{ $bill->bill_number }}</h2>
                <div class="text-sm text-gray-500">{{ $bill->bill_date->format('d M Y') }}</div>
            </div>
            <div class="flex space-x-2">
                <a href="{{ route('invoices.print', $bill->id) }}" target="_blank" class="bg-green-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-green-700"><i class="fas fa-print mr-1"></i>Print Invoice</a>
                <a href="{{ route('bills.edit', $bill->id) }}" class="bg-blue-600 text-white text-sm px-4 py-2 rounded-lg hover:bg-blue-700"><i class="fas fa-edit mr-1"></i>Edit</a>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mb-6 text-sm">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="font-semibold text-gray-700 mb-2">Patient</div>
                <div class="font-bold text-gray-800">{{ $bill->patient->name ?? 'N/A' }}</div>
                <div class="text-gray-500">{{ $bill->patient->phone ?? '' }}</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="font-semibold text-gray-700 mb-2">Doctor</div>
                <div class="font-bold text-gray-800">{{ $bill->doctor->name ?? 'N/A' }}</div>
                <div class="text-gray-500">{{ $bill->doctor->specialization ?? '' }}</div>
            </div>
        </div>

        <table class="min-w-full mb-4">
            <thead class="bg-blue-50">
                <tr>
                    <th class="px-4 py-2 text-left text-xs font-semibold text-blue-700">Description</th>
                    <th class="px-4 py-2 text-center text-xs font-semibold text-blue-700">Qty</th>
                    <th class="px-4 py-2 text-right text-xs font-semibold text-blue-700">Unit Price</th>
                    <th class="px-4 py-2 text-right text-xs font-semibold text-blue-700">Total</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @foreach($bill->items as $item)
                <tr><td class="px-4 py-3 text-sm">{{ $item->description }}</td><td class="px-4 py-3 text-sm text-center">{{ $item->quantity }}</td><td class="px-4 py-3 text-sm text-right">₹{{ number_format($item->unit_price, 2) }}</td><td class="px-4 py-3 text-sm text-right font-medium">₹{{ number_format($item->total, 2) }}</td></tr>
                @endforeach
            </tbody>
        </table>

        <div class="border-t pt-4 space-y-2 text-sm">
            <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span class="font-medium">₹{{ number_format($bill->subtotal, 2) }}</span></div>
            @if($bill->discount > 0)<div class="flex justify-between text-green-600"><span>Discount</span><span>- ₹{{ number_format($bill->discount, 2) }}</span></div>@endif
            <div class="flex justify-between text-lg font-bold border-t pt-2"><span>Total Amount</span><span class="text-blue-700">₹{{ number_format($bill->total_amount, 2) }}</span></div>
            <div class="flex justify-between">
                <span class="text-gray-500">Payment Status</span>
                <span class="px-3 py-0.5 rounded-full text-sm font-semibold {{ $bill->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">{{ ucfirst($bill->payment_status) }}</span>
            </div>
            @if($bill->payment_method)<div class="flex justify-between"><span class="text-gray-500">Payment Method</span><span>{{ $bill->payment_method }}</span></div>@endif
        </div>
    </div>
</div>
@endsection
