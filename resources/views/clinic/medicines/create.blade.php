@extends('layouts.clinic')
@section('title','Add Medicine')
@section('page-title','Add Medicine')
@section('breadcrumb','Home / Medicines / Add')

@section('content')
<div class="py-4 max-w-2xl">
    <div class="bg-white rounded-xl shadow-sm p-6">
        <form action="{{ route('medicines.store') }}" method="POST">
            @csrf
            <div class="grid grid-cols-2 gap-4">
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Medicine Name <span class="text-red-500">*</span></label><input type="text" name="name" value="{{ old('name') }}" placeholder="Brand name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Generic Name</label><input type="text" name="generic_name" value="{{ old('generic_name') }}" placeholder="Generic/chemical name" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Category <span class="text-red-500">*</span></label><select name="category" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">@foreach(['Tablet','Syrup','Injection','Capsule','Cream','Drops','Inhaler','Other'] as $c)<option value="{{ $c }}" {{ old('category') == $c ? 'selected' : '' }}>{{ $c }}</option>@endforeach</select></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Manufacturer</label><input type="text" name="manufacturer" value="{{ old('manufacturer') }}" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Unit Price (₹) <span class="text-red-500">*</span></label><input type="number" name="unit_price" value="{{ old('unit_price') }}" step="0.01" min="0" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none"></div>
                <div><label class="block text-sm font-medium text-gray-700 mb-1">Unit <span class="text-red-500">*</span></label><select name="unit" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">@foreach(['Piece','Strip','Bottle','Vial','Tube','Box'] as $u)<option value="{{ $u }}">{{ $u }}</option>@endforeach</select></div>
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Description</label><textarea name="description" rows="2" class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">{{ old('description') }}</textarea></div>
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Side Effects</label><textarea name="side_effects" rows="2" placeholder="Known side effects..." class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">{{ old('side_effects') }}</textarea></div>
                <div class="col-span-2"><label class="block text-sm font-medium text-gray-700 mb-1">Contraindications</label><textarea name="contraindications" rows="2" placeholder="When NOT to use..." class="w-full border border-gray-300 rounded-lg px-3 py-2.5 focus:ring-2 focus:ring-blue-400 outline-none">{{ old('contraindications') }}</textarea></div>
                <div class="col-span-2"><label class="flex items-center space-x-2 cursor-pointer"><input type="checkbox" name="requires_prescription" value="1" class="rounded"><span class="text-sm font-medium text-gray-700">Requires Prescription (Rx)</span></label></div>
            </div>
            <div class="flex space-x-3 mt-6">
                <button type="submit" class="bg-blue-600 hover:bg-blue-700 text-white px-6 py-2.5 rounded-lg font-medium transition"><i class="fas fa-save mr-2"></i>Add Medicine</button>
                <a href="{{ route('medicines.index') }}" class="bg-gray-100 hover:bg-gray-200 text-gray-700 px-6 py-2.5 rounded-lg font-medium transition">Cancel</a>
            </div>
        </form>
    </div>
</div>
@endsection
