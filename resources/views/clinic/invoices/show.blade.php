@extends('layouts.clinic')
@section('title','Invoice')
@section('page-title','Invoice')
@section('breadcrumb','Home / Invoices / View')

@section('content')
<div class="py-4 max-w-3xl">
    <div class="bg-white rounded-xl shadow-sm p-8">
        <div class="flex justify-between items-start mb-8">
            <div>
                <div class="flex items-center space-x-3 mb-2">
                    <div class="w-12 h-12 bg-blue-600 rounded-xl flex items-center justify-center"><i class="fas fa-hospital text-white text-xl"></i></div>
                    <div><div class="text-xl font-bold text-gray-800">HealthCare Clinic</div><div class="text-sm text-gray-500">123 Medical Street, City - 400001</div></div>
                </div>
            </div>
            <div class="text-right">
                <div class="text-2xl font-bold text-blue-700">INVOICE</div>
                <div class="text-lg font-mono text-gray-600">{{ $invoice->bill_number }}</div>
                <div class="text-sm text-gray-500">{{ $invoice->bill_date->format('d M Y') }}</div>
                <span class="inline-block mt-2 px-3 py-1 rounded-full text-sm font-semibold {{ $invoice->payment_status === 'paid' ? 'bg-green-100 text-green-700' : 'bg-orange-100 text-orange-700' }}">{{ ucfirst($invoice->payment_status) }}</span>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-6 mb-8">
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-xs font-semibold text-gray-500 uppercase mb-2">Bill To</div>
                <div class="font-bold text-gray-800">{{ $invoice->patient->name ?? 'N/A' }}</div>
                <div class="text-sm text-gray-600">{{ $invoice->patient->phone ?? '' }}</div>
                <div class="text-sm text-gray-600">{{ $invoice->patient->address ?? '' }}</div>
            </div>
            <div class="bg-gray-50 rounded-lg p-4">
                <div class="text-xs font-semibold text-gray-500 uppercase mb-2">Doctor</div>
                <div class="font-bold text-gray-800">{{ $invoice->doctor->name ?? 'N/A' }}</div>
                <div class="text-sm text-gray-600">{{ $invoice->doctor->specialization ?? '' }}</div>
                <div class="text-sm text-gray-600">{{ $invoice->doctor->qualification ?? '' }}</div>
            </div>
        </div>

        <table class="min-w-full mb-6">
            <thead><tr class="bg-blue-600 text-white">
                <th class="px-4 py-3 text-left text-sm">Description</th>
                <th class="px-4 py-3 text-center text-sm">Qty</th>
                <th class="px-4 py-3 text-right text-sm">Rate</th>
                <th class="px-4 py-3 text-right text-sm">Amount</th>
            </tr></thead>
            <tbody class="divide-y divide-gray-100">
                @foreach($invoice->items as $item)
                <tr><td class="px-4 py-3 text-sm">{{ $item->description }}</td><td class="px-4 py-3 text-sm text-center">{{ $item->quantity }}</td><td class="px-4 py-3 text-sm text-right">₹{{ number_format($item->unit_price, 2) }}</td><td class="px-4 py-3 text-sm text-right font-medium">₹{{ number_format($item->total, 2) }}</td></tr>
                @endforeach
            </tbody>
        </table>

        <div class="flex justify-end">
            <div class="w-64 space-y-2 text-sm">
                <div class="flex justify-between"><span class="text-gray-500">Subtotal</span><span>₹{{ number_format($invoice->subtotal, 2) }}</span></div>
                @if($invoice->discount > 0)<div class="flex justify-between text-green-600"><span>Discount</span><span>-₹{{ number_format($invoice->discount, 2) }}</span></div>@endif
                <div class="flex justify-between text-lg font-bold border-t pt-2"><span>Total</span><span class="text-blue-700">₹{{ number_format($invoice->total_amount, 2) }}</span></div>
            </div>
        </div>

        <div class="mt-8 border-t pt-4 flex justify-between">
            <a href="{{ route('invoices.print', $invoice->id) }}" target="_blank" class="bg-green-600 text-white px-6 py-2 rounded-lg hover:bg-green-700 text-sm"><i class="fas fa-print mr-2"></i>Print Invoice</a>
            <a href="{{ route('invoices.index') }}" class="bg-gray-100 text-gray-700 px-6 py-2 rounded-lg hover:bg-gray-200 text-sm">← Back</a>
        </div>
    </div>
</div>
@endsection
