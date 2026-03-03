@extends('layouts.admin')
@section('title', 'Notices')
@section('page-title', 'Notice Board')
@section('breadcrumb', 'Home / Notices')

@section('content')
<div class="py-4">
    <div class="flex justify-between items-center mb-6">
        <p class="text-gray-500 text-sm">Publish and manage society notices</p>
        <a href="{{ route('admin.notices.create') }}" class="bg-teal-600 hover:bg-teal-700 text-white px-4 py-2 rounded-lg text-sm font-medium transition flex items-center space-x-2">
            <i class="fas fa-plus"></i><span>Post Notice</span>
        </a>
    </div>
    <div class="space-y-4">
        @forelse($notices as $n)
        <div class="bg-white rounded-xl shadow-sm p-5 flex items-start justify-between">
            <div class="flex-1">
                <div class="flex items-center space-x-2 mb-1">
                    <span class="text-xs px-2 py-0.5 rounded-full font-medium
                        {{ $n->category === 'Emergency' ? 'bg-red-100 text-red-700' : ($n->category === 'Meeting' ? 'bg-purple-100 text-purple-700' : ($n->category === 'Payment' ? 'bg-orange-100 text-orange-700' : 'bg-teal-100 text-teal-700')) }}">
                        {{ $n->category }}
                    </span>
                    @if(!$n->active)<span class="text-xs bg-gray-100 text-gray-500 px-2 py-0.5 rounded-full">Inactive</span>@endif
                    @if($n->expires_at && $n->expires_at->isPast())<span class="text-xs bg-red-100 text-red-500 px-2 py-0.5 rounded-full">Expired</span>@endif
                </div>
                <h3 class="font-semibold text-gray-800 mb-1">{{ $n->title }}</h3>
                <p class="text-sm text-gray-500 line-clamp-2">{{ Str::limit($n->content, 120) }}</p>
                <div class="text-xs text-gray-400 mt-2">Posted: {{ $n->created_at->format('d M Y') }} @if($n->expires_at) &bull; Expires: {{ $n->expires_at->format('d M Y') }} @endif</div>
            </div>
            <div class="flex space-x-1 ml-4">
                <a href="{{ route('admin.notices.edit', $n->id) }}" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded"><i class="fas fa-edit"></i></a>
                <form action="{{ route('admin.notices.destroy', $n->id) }}" method="POST" class="inline">
                    @csrf @method('DELETE')
                    <button type="submit" onclick="return confirm('Delete notice?')" class="p-1.5 text-red-600 hover:bg-red-50 rounded"><i class="fas fa-trash"></i></button>
                </form>
            </div>
        </div>
        @empty
        <div class="text-center py-16 bg-white rounded-xl"><i class="fas fa-bullhorn text-5xl text-gray-200 mb-4"></i><p class="text-gray-400">No notices posted yet.</p></div>
        @endforelse
    </div>
    <div class="mt-4">{{ $notices->links() }}</div>
</div>
@endsection
