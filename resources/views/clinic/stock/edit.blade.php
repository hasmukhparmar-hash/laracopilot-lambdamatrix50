@extends('layouts.clinic')
@section('title','Edit Stock')
@section('page-title','Edit Stock Level')
@section('breadcrumb','Home / Stock / Edit')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <div class="mb-4 bg-blue-50 border border-blue-100 rounded-lg p-4">
            <div class="font-semibold text-blue-800">{{ $stock->medicine->name ?? 'N/A' }}</div>
            <div class="text-sm text-blue-600">Current Stock: <strong>{{ $stock->quantity }}</strong> {{ $stock->medicine->unit ?? '' }}</div>
        </div>
        <form action="{{ route('stock.update', $stock->id) }}" method="POST">
            @csrf @method('PUT')
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" value="{{ $stock->quantity }}" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reorder Level <span class="text-red-500">*</span></label>
                    <input type="number" name="reorder_level" value="{{ $stock->reorder_level }}" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                    <input type="date" name="expiry_date" value="{{ $stock->expiry_date?->format('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batch Number</label>
                    <input type="text" name="batch_number" value="{{ $stock->batch_number }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition"><i class="fas fa-save mr-2"></i>Update</button>
                <a href="{{ route('stock.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
