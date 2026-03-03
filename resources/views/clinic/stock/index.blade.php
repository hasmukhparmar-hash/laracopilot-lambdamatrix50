@extends('layouts.clinic')
@section('title','Stock')
@section('page-title','Medicine Stock')
@section('breadcrumb','Home / Stock')

@section('content')
<div class="py-4">
    <div class="grid grid-cols-3 gap-4 mb-6">
        <div class="bg-red-50 border border-red-200 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-red-600">{{ $lowStockCount }}</div>
            <div class="text-xs text-gray-500 mt-1">Low Stock Items</div>
        </div>
        <div class="bg-gray-50 border border-gray-200 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-gray-700">{{ $outOfStockCount }}</div>
            <div class="text-xs text-gray-500 mt-1">Out of Stock</div>
        </div>
        <div class="bg-orange-50 border border-orange-200 rounded-xl p-4 text-center">
            <div class="text-2xl font-bold text-orange-600">{{ $expiringSoon }}</div>
            <div class="text-xs text-gray-500 mt-1">Expiring in 30 Days</div>
        </div>
    </div>
    <div class="flex justify-between items-center mb-4">
        <p class="text-gray-500 text-sm">Manage medicine stock levels</p>
        <a href="{{ route('stock.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center space-x-2">
            <i class="fas fa-plus"></i><span>Add Stock</span>
        </a>
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Medicine</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Stock</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Reorder Level</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Expiry</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Supplier</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Status</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($stocks as $stock)
                <tr class="hover:bg-gray-50 {{ $stock->quantity == 0 ? 'bg-red-50' : ($stock->quantity <= $stock->reorder_level ? 'bg-yellow-50' : '') }}">
                    <td class="px-4 py-3">
                        <div class="font-medium text-sm text-gray-800">{{ $stock->medicine->name ?? 'N/A' }}</div>
                        <div class="text-xs text-gray-400">{{ $stock->medicine->generic_name ?? '' }}</div>
                    </td>
                    <td class="px-4 py-3"><span class="text-xs bg-purple-100 text-purple-700 px-2 py-0.5 rounded-full">{{ $stock->medicine->category ?? '' }}</span></td>
                    <td class="px-4 py-3">
                        <span class="text-lg font-bold {{ $stock->quantity == 0 ? 'text-red-600' : ($stock->quantity <= $stock->reorder_level ? 'text-orange-500' : 'text-green-600') }}">
                            {{ $stock->quantity }}
                        </span>
                        <span class="text-xs text-gray-400 ml-1">{{ $stock->medicine->unit ?? '' }}</span>
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $stock->reorder_level }}</td>
                    <td class="px-4 py-3 text-sm {{ $stock->expiry_date && $stock->expiry_date->isPast() ? 'text-red-600 font-semibold' : ($stock->expiry_date && $stock->expiry_date->diffInDays(now()) <= 30 ? 'text-orange-500' : 'text-gray-600') }}">
                        {{ $stock->expiry_date ? $stock->expiry_date->format('d M Y') : '—' }}
                    </td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $stock->supplier ?? '—' }}</td>
                    <td class="px-4 py-3">
                        @if($stock->quantity == 0)
                            <span class="text-xs bg-red-100 text-red-700 px-2 py-0.5 rounded-full font-semibold">Out of Stock</span>
                        @elseif($stock->quantity <= $stock->reorder_level)
                            <span class="text-xs bg-orange-100 text-orange-700 px-2 py-0.5 rounded-full font-semibold">Low Stock</span>
                        @else
                            <span class="text-xs bg-green-100 text-green-700 px-2 py-0.5 rounded-full">In Stock</span>
                        @endif
                    </td>
                    <td class="px-4 py-3 text-right">
                        <a href="{{ route('stock.edit', $stock->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded inline-block"><i class="fas fa-edit text-sm"></i></a>
                    </td>
                </tr>
                @empty
                <tr><td colspan="8" class="text-center py-12 text-gray-400">No stock records found.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $stocks->links() }}</div>
    </div>
</div>
@endsection
