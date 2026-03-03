@extends('layouts.clinic')
@section('title','Edit Bill')
@section('page-title','Edit Bill')
@section('breadcrumb','Home / Bills / Edit')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="mb-4 bg-gray-50 rounded-lg p-4 text-sm">
            <div class="font-semibold text-gray-700">{{ $bill->bill_number }}</div>
            <div class="text-gray-500">Patient: {{ $bill->patient->name ?? 'N/A' }} &bull; ₹{{ number_format($bill->total_amount) }}</div>
        </div>
        <form action="{{ route('bills.update', $bill->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status</label>
                    <select name="payment_status" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                        @foreach(['pending','paid','partial'] as $s)<option value="{{ $s }}" {{ $bill->payment_status == $s ? 'selected' : '' }}>{{ ucfirst($s) }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                    <select name="payment_method" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                        <option value="">Select</option>
                        @foreach(['Cash','Card','UPI','Online','Insurance'] as $m)<option value="{{ $m }}" {{ $bill->payment_method == $m ? 'selected' : '' }}>{{ $m }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount (₹)</label>
                    <input type="number" name="discount" value="{{ $bill->discount }}" min="0" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <input type="text" name="notes" value="{{ $bill->notes }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition"><i class="fas fa-save mr-2"></i>Update Bill</button>
                <a href="{{ route('bills.show', $bill->id) }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
