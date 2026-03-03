@extends('layouts.clinic')
@section('title','Add Stock')
@section('page-title','Add Medicine Stock')
@section('breadcrumb','Home / Stock / Add')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('stock.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Medicine <span class="text-red-500">*</span></label>
                    <select name="medicine_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                        <option value="">Select Medicine</option>
                        @foreach($medicines as $med)
                        <option value="{{ $med->id }}">{{ $med->name }} ({{ $med->category }}) - Current Stock: {{ $med->stock->quantity ?? 0 }}</option>
                        @endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Quantity to Add <span class="text-red-500">*</span></label>
                    <input type="number" name="quantity" min="1" placeholder="e.g. 100" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Reorder Level <span class="text-red-500">*</span></label>
                    <input type="number" name="reorder_level" min="1" value="10" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Expiry Date</label>
                    <input type="date" name="expiry_date" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Batch Number</label>
                    <input type="text" name="batch_number" placeholder="e.g. BATCH-2024" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Purchase Price (₹)</label>
                    <input type="number" name="purchase_price" step="0.01" min="0" placeholder="0.00" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Supplier</label>
                    <input type="text" name="supplier" placeholder="Supplier name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
            </div>
            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition"><i class="fas fa-save mr-2"></i>Update Stock</button>
                <a href="{{ route('stock.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
