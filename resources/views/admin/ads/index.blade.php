@extends('layouts.admin')

@section('title', 'Ads')
@section('page-title', 'Ads Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">Manage advertisements (Google AdSense, Adsera, Manual HTML)</p>
        </div>
        <a href="{{ route('admin.ads.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-medium shadow-sm">
            <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
            </svg>
            Create New Ad
        </a>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.ads.index') }}" class="flex flex-wrap gap-4">
            <div class="min-w-[150px]">
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="adsense" {{ request('type') == 'adsense' ? 'selected' : '' }}>Google AdSense</option>
                    <option value="adsera" {{ request('type') == 'adsera' ? 'selected' : '' }}>Adsera</option>
                    <option value="manual" {{ request('type') == 'manual' ? 'selected' : '' }}>Manual HTML</option>
                </select>
            </div>
            <div class="min-w-[150px]">
                <select name="position" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Positions</option>
                    <option value="header" {{ request('position') == 'header' ? 'selected' : '' }}>Header</option>
                    <option value="footer" {{ request('position') == 'footer' ? 'selected' : '' }}>Footer</option>
                    <option value="sidebar" {{ request('position') == 'sidebar' ? 'selected' : '' }}>Sidebar</option>
                    <option value="content_top" {{ request('position') == 'content_top' ? 'selected' : '' }}>Content Top</option>
                    <option value="content_bottom" {{ request('position') == 'content_bottom' ? 'selected' : '' }}>Content Bottom</option>
                    <option value="between_posts" {{ request('position') == 'between_posts' ? 'selected' : '' }}>Between Posts</option>
                </select>
            </div>
            <button type="submit" class="px-6 py-2 bg-gray-800 text-white rounded-lg hover:bg-gray-900 transition-all font-medium">
                Filter
            </button>
            @if(request('type') || request('position'))
            <a href="{{ route('admin.ads.index') }}" class="px-6 py-2 bg-gray-200 text-gray-700 rounded-lg hover:bg-gray-300 transition-all font-medium">
                Reset
            </a>
            @endif
        </form>
    </div>

    <!-- Ads Grid -->
    <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
        @forelse($ads as $ad)
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden hover:shadow-md transition-shadow">
            <!-- Header -->
            <div class="p-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <div class="flex items-start justify-between">
                    <div class="flex-1">
                        <h3 class="font-semibold text-gray-900">{{ $ad->name }}</h3>
                        <div class="flex items-center gap-2 mt-1">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full 
                                {{ $ad->type === 'adsense' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $ad->type === 'adsera' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $ad->type === 'manual' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($ad->type) }}
                            </span>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full {{ $ad->is_active ? 'bg-green-100 text-green-800' : 'bg-red-100 text-red-800' }}">
                                {{ $ad->is_active ? 'Active' : 'Inactive' }}
                            </span>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Body -->
            <div class="p-4 space-y-3">
                <!-- Position -->
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z"/>
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 11a3 3 0 11-6 0 3 3 0 016 0z"/>
                    </svg>
                    <span class="text-gray-600">Position:</span>
                    <span class="ml-1 font-medium text-gray-900">{{ str_replace('_', ' ', ucfirst($ad->position)) }}</span>
                </div>

                <!-- Sort Order -->
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                    </svg>
                    <span class="text-gray-600">Order:</span>
                    <span class="ml-1 font-medium text-gray-900">{{ $ad->sort_order }}</span>
                </div>

                <!-- Code Preview -->
                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500 mb-1">Code Preview:</p>
                    <code class="text-xs text-gray-700 break-all line-clamp-2">{{ Str::limit($ad->code, 80) }}</code>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 flex items-center justify-end gap-2">
                <a href="{{ route('admin.ads.edit', $ad) }}" 
                    class="px-3 py-1.5 text-sm text-blue-600 hover:text-blue-900 hover:bg-blue-50 rounded transition-colors font-medium">
                    Edit
                </a>
                <button onclick="deleteAd({{ $ad->id }}, '{{ route('admin.ads.destroy', $ad) }}')" 
                    class="px-3 py-1.5 text-sm text-red-600 hover:text-red-900 hover:bg-red-50 rounded transition-colors font-medium">
                    Delete
                </button>
            </div>
        </div>
        @empty
        <div class="col-span-full">
            <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-12 text-center">
                <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12h6m-6 4h6m2 5H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/>
                </svg>
                <p class="text-lg font-medium text-gray-900">No ads found</p>
                <p class="mt-2 text-gray-600">Create your first ad to get started</p>
                <a href="{{ route('admin.ads.create') }}" class="mt-4 inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-medium">
                    <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                    </svg>
                    Create New Ad
                </a>
            </div>
        </div>
        @endforelse
    </div>

    <!-- Pagination -->
    @if($ads->hasPages())
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 px-6 py-4">
        {{ $ads->links() }}
    </div>
    @endif
</div>

@push('scripts')
<script>
async function deleteAd(adId, deleteUrl) {
    const confirmed = await window.confirmDelete('Delete Ad', 'Are you sure you want to delete this ad? This action cannot be undone.');
    if (!confirmed) return;

    try {
        const response = await fetch(deleteUrl, {
            method: 'DELETE',
            headers: {
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                'Accept': 'application/json'
            }
        });

        const data = await response.json();

        if (data.success || response.ok) {
            window.showToast('success', 'Ad berhasil dihapus!');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            window.showToast('error', data.message || 'Delete failed');
        }
    } catch (error) {
        console.error('Delete error:', error);
        window.showToast('error', 'Delete failed. Please try again.');
    }
}
</script>
@endpush
@endsection
