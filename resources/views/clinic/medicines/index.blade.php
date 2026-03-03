@extends('layouts.clinic')
@section('title','Medicines')
@section('page-title','Medicine Inventory')
@section('breadcrumb','Home / Medicines')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">All registered medicines</p>
        @if(session('clinic_role') !== 'nurse')
        <a href="{{ route('medicines.create') }}" class="bg-blue-600 hover:bg-blue-700 text-white px-4 py-2 rounded-lg text-sm font-medium flex items-center space-x-2">
            <i class="fas fa-plus"></i><span>Add Medicine</span>
        </a>
        @endif
    </div>
    <div class="bg-white rounded-xl shadow-sm overflow-hidden">
        <table class="min-w-full divide-y divide-gray-100">
            <thead class="bg-gray-50">
                <tr>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Medicine</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Category</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Manufacturer</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Price</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Stock</th>
                    <th class="px-4 py-3 text-left text-xs font-semibold text-gray-500 uppercase">Rx</th>
                    <th class="px-4 py-3 text-right text-xs font-semibold text-gray-500 uppercase">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-50">
                @forelse($medicines as $med)
                <tr class="hover:bg-gray-50 {{ ($med->stock && $med->stock->quantity <= $med->stock->reorder_level) ? 'bg-red-50' : '' }}">
                    <td class="px-4 py-3">
                        <div class="font-medium text-sm text-gray-800">{{ $med->name }}</div>
                        <div class="text-xs text-gray-400">{{ $med->generic_name }}</div>
                    </td>
                    <td class="px-4 py-3"><span class="bg-purple-100 text-purple-700 text-xs px-2 py-0.5 rounded-full">{{ $med->category }}</span></td>
                    <td class="px-4 py-3 text-sm text-gray-600">{{ $med->manufacturer ?? '—' }}</td>
                    <td class="px-4 py-3 text-sm font-semibold text-gray-700">₹{{ number_format($med->unit_price, 2) }}/{{ $med->unit }}</td>
                    <td class="px-4 py-3">
                        @if($med->stock)
                            <span class="font-bold {{ $med->stock->quantity <= 10 ? 'text-red-600' : 'text-green-600' }}">{{ $med->stock->quantity }}</span>
                            <span class="text-xs text-gray-400"> units</span>
                        @else<span class="text-gray-300 text-xs">No stock</span>@endif
                    </td>
                    <td class="px-4 py-3">{{ $med->requires_prescription ? '<span class="text-xs bg-red-100 text-red-600 px-1.5 rounded">Rx</span>' : '<span class="text-xs text-gray-300">OTC</span>' }}</td>
                    <td class="px-4 py-3 text-right">
                        @if(session('clinic_role') !== 'nurse')
                        <div class="flex justify-end space-x-1">
                            <a href="{{ route('medicines.edit', $med->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit text-sm"></i></a>
                            @if(session('clinic_role') === 'admin')
                            <form action="{{ route('medicines.destroy', $med->id) }}" method="POST" class="inline">@csrf @method('DELETE')
                                <button onclick="return confirm('Delete medicine?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash text-sm"></i></button>
                            </form>
                            @endif
                        </div>
                        @endif
                    </td>
                </tr>
                @empty
                <tr><td colspan="7" class="text-center py-12 text-gray-400">No medicines added.</td></tr>
                @endforelse
            </tbody>
        </table>
        <div class="px-4 py-3 border-t">{{ $medicines->links() }}</div>
    </div>
</div>
@endsection
