@extends('layouts.clinic')
@section('title','Create Bill')
@section('page-title','Create New Bill')
@section('breadcrumb','Home / Bills / Create')

@section('content')
<div class="py-4 max-w-4xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('bills.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4 mb-6">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Patient <span class="text-red-500">*</span></label>
                    <select name="patient_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                        <option value="">Select Patient</option>
                        @foreach($patients as $p)<option value="{{ $p->id }}" {{ request('patient_id') == $p->id ? 'selected' : '' }}>{{ $p->name }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Doctor <span class="text-red-500">*</span></label>
                    <select name="doctor_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                        <option value="">Select Doctor</option>
                        @foreach($doctors as $d)<option value="{{ $d->id }}">{{ $d->name }} - Consultation ₹{{ $d->consultation_fee }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Linked Inspection</label>
                    <select name="inspection_id" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                        <option value="">None</option>
                        @foreach($inspections as $i)<option value="{{ $i->id }}" {{ request('inspection_id') == $i->id ? 'selected' : '' }}>{{ $i->patient->name ?? '' }} - {{ $i->inspection_date->format('d M Y') }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Bill Date <span class="text-red-500">*</span></label>
                    <input type="date" name="bill_date" value="{{ date('Y-m-d') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Status <span class="text-red-500">*</span></label>
                    <select name="payment_status" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none" required>
                        @foreach(['pending','paid','partial'] as $s)<option value="{{ $s }}">{{ ucfirst($s) }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Payment Method</label>
                    <select name="payment_method" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                        <option value="">Select</option>
                        @foreach(['Cash','Card','UPI','Online','Insurance'] as $m)<option value="{{ $m }}">{{ $m }}</option>@endforeach
                    </select>
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Discount (₹)</label>
                    <input type="number" name="discount" value="0" min="0" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
                <div class="col-span-2">
                    <label class="block text-sm font-medium text-gray-700 mb-1">Notes</label>
                    <input type="text" name="notes" placeholder="Optional notes" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">
                </div>
            </div>

            <!-- Bill Items -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-3">
                    <h4 class="font-semibold text-gray-700"><i class="fas fa-list text-blue-500 mr-2"></i>Bill Items</h4>
                    <button type="button" onclick="addBillItem()" class="bg-blue-600 text-white text-xs px-3 py-1.5 rounded-lg hover:bg-blue-700"><i class="fas fa-plus mr-1"></i>Add Item</button>
                </div>
                <div class="grid grid-cols-12 gap-2 mb-1 text-xs font-semibold text-gray-500 px-1">
                    <div class="col-span-5">Description</div><div class="col-span-2">Qty</div><div class="col-span-3">Unit Price</div><div class="col-span-2"></div>
                </div>
                <div id="bill-items">
                    <div class="grid grid-cols-12 gap-2 mb-2 items-center">
                        <div class="col-span-5"><input type="text" name="items[0][description]" placeholder="Consultation Fee" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none" required></div>
                        <div class="col-span-2"><input type="number" name="items[0][quantity]" value="1" min="1" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none" required></div>
                        <div class="col-span-3"><input type="number" name="items[0][unit_price]" placeholder="500" step="0.01" class="w-full border border-gray-300 rounded-lg px-3 py-2 text-sm focus:ring-2 focus:ring-blue-400 outline-none" required></div>
                        <div class="col-span-2"><span class="text-xs text-gray-400">Base Item</span></div>
                    </div>
                </div>
            </div>

            <div class="flex space-x-3">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition"><i class="fas fa-file-invoice-dollar mr-2"></i>Generate Bill</button>
                <a href="{{ route('bills.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
