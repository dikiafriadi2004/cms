@extends('layouts.admin')

@section('title', 'Ads')
@section('page-title', 'Ads Management')

@section('content')
<div class="space-y-6">
    <!-- Header -->
    <div class="flex justify-between items-center">
        <div>
            <p class="text-gray-600">Manage advertisements (Image Banners, Google AdSense, Adsera, Manual HTML)</p>
        </div>
        <div class="flex items-center gap-3">
            <a href="{{ route('admin.ads.create') }}" class="inline-flex items-center px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-all font-medium shadow-sm">
                <svg class="w-5 h-5 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 4v16m8-8H4"/>
                </svg>
                Create New Ad
            </a>
        </div>
    </div>

    <!-- Ad Rotation Info -->
    <div class="bg-gradient-to-r from-orange-50 to-amber-50 rounded-xl border border-orange-200 p-4">
        <div class="flex items-start gap-3">
            <div class="flex-shrink-0">
                <svg class="w-6 h-6 text-orange-600" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                </svg>
            </div>
            <div class="flex-1">
                <h3 class="text-sm font-semibold text-gray-900 mb-1">🔄 Ad Rotation Feature</h3>
                <p class="text-sm text-gray-700 mb-2">Group multiple ads to rotate in the same position. Ads with the same rotation group name will automatically rotate.</p>
                <div class="grid grid-cols-1 md:grid-cols-3 gap-3 text-xs">
                    <div class="bg-white rounded-lg p-2 border border-orange-100">
                        <span class="font-semibold text-orange-800">Random:</span>
                        <span class="text-gray-600">Show random ad from group</span>
                    </div>
                    <div class="bg-white rounded-lg p-2 border border-orange-100">
                        <span class="font-semibold text-orange-800">Weighted:</span>
                        <span class="text-gray-600">Higher weight = more likely to show</span>
                    </div>
                    <div class="bg-white rounded-lg p-2 border border-orange-100">
                        <span class="font-semibold text-orange-800">Sequential:</span>
                        <span class="text-gray-600">Rotate evenly based on impressions</span>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <!-- Filters -->
    <div class="bg-white rounded-xl shadow-sm border border-gray-200 p-4">
        <form method="GET" action="{{ route('admin.ads.index') }}" class="flex flex-wrap gap-4">
            <div class="min-w-[150px]">
                <select name="type" class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent">
                    <option value="">All Types</option>
                    <option value="image" {{ request('type') == 'image' ? 'selected' : '' }}>Image Banner</option>
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
                    <option value="in_content" {{ request('position') == 'in_content' ? 'selected' : '' }}>In Content</option>
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
                        <div class="flex items-center gap-2 mt-1 flex-wrap">
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full 
                                {{ $ad->type === 'image' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $ad->type === 'adsense' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $ad->type === 'adsera' ? 'bg-purple-100 text-purple-800' : '' }}
                                {{ $ad->type === 'manual' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ $ad->type === 'image' ? 'Image' : ucfirst($ad->type) }}
                            </span>
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full 
                                {{ $ad->status_color === 'green' ? 'bg-green-100 text-green-800' : '' }}
                                {{ $ad->status_color === 'blue' ? 'bg-blue-100 text-blue-800' : '' }}
                                {{ $ad->status_color === 'red' ? 'bg-red-100 text-red-800' : '' }}
                                {{ $ad->status_color === 'gray' ? 'bg-gray-100 text-gray-800' : '' }}">
                                {{ ucfirst($ad->status) }}
                            </span>
                            @if($ad->rotation_group)
                            <span class="px-2 py-0.5 text-xs font-medium rounded-full bg-orange-100 text-orange-800">
                                🔄 {{ $ad->rotation_group }}
                            </span>
                            @endif
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

                <!-- Rotation Info -->
                @if($ad->rotation_group)
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 4v5h.582m15.356 2A8.001 8.001 0 004.582 9m0 0H9m11 11v-5h-.581m0 0a8.003 8.003 0 01-15.357-2m15.357 2H15"/>
                    </svg>
                    <span class="text-gray-600">Rotation:</span>
                    <span class="ml-1 font-medium text-gray-900">{{ ucfirst($ad->rotation_mode) }}</span>
                    @if($ad->rotation_mode === 'weighted')
                    <span class="ml-1 text-xs text-gray-500">(Weight: {{ $ad->rotation_weight }})</span>
                    @endif
                </div>
                @endif

                <!-- Sort Order -->
                <div class="flex items-center text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 16V4m0 0L3 8m4-4l4 4m6 0v12m0 0l4-4m-4 4l-4-4"/>
                    </svg>
                    <span class="text-gray-600">Order:</span>
                    <span class="ml-1 font-medium text-gray-900">{{ $ad->sort_order }}</span>
                </div>

                <!-- Date Range -->
                @if($ad->start_date || $ad->end_date)
                <div class="flex items-start text-sm">
                    <svg class="w-4 h-4 text-gray-400 mr-2 mt-0.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                    </svg>
                    <div class="flex-1">
                        @if($ad->start_date)
                        <div class="text-gray-600">
                            <span class="text-xs">Start:</span>
                            <span class="ml-1 font-medium text-gray-900">{{ $ad->start_date->format('d M Y') }}</span>
                        </div>
                        @endif
                        @if($ad->end_date)
                        <div class="text-gray-600">
                            <span class="text-xs">End:</span>
                            <span class="ml-1 font-medium {{ $ad->isExpired() ? 'text-red-600' : 'text-gray-900' }}">{{ $ad->end_date->format('d M Y') }}</span>
                        </div>
                        @endif
                    </div>
                </div>
                @endif

                <!-- Code Preview -->
                <div class="mt-3 p-3 bg-gray-50 rounded-lg">
                    <p class="text-xs text-gray-500 mb-1">Code Preview:</p>
                    <code class="text-xs text-gray-700 break-all line-clamp-2">{{ Str::limit($ad->code, 80) }}</code>
                </div>
            </div>

            <!-- Footer Actions -->
            <div class="px-4 py-3 bg-gray-50 border-t border-gray-200 flex items-center justify-between gap-2">
                <!-- Toggle Status -->
                <div class="flex items-center gap-2">
                    <label class="relative inline-flex items-center cursor-pointer">
                        <input type="checkbox" 
                            class="sr-only peer toggle-status" 
                            data-ad-id="{{ $ad->id }}"
                            {{ $ad->is_active ? 'checked' : '' }}>
                        <div class="w-11 h-6 bg-gray-300 peer-focus:outline-none peer-focus:ring-4 peer-focus:ring-blue-300 rounded-full peer peer-checked:bg-green-500 peer-checked:after:translate-x-full after:content-[''] after:absolute after:top-[2px] after:left-[2px] after:bg-white after:border-gray-300 after:border after:rounded-full after:h-5 after:w-5 after:transition-all"></div>
                    </label>
                    <span class="text-xs font-semibold status-label-{{ $ad->id }} {{ $ad->is_active ? 'text-green-600' : 'text-gray-500' }}">
                        {{ $ad->is_active ? 'Active' : 'Inactive' }}
                    </span>
                </div>

                <!-- Action Buttons -->
                <div class="flex items-center gap-2">
                    <a href="{{ route('admin.ads.analytics.show', $ad) }}" 
                        class="px-3 py-1.5 text-sm text-purple-600 hover:text-purple-900 hover:bg-purple-50 rounded transition-colors font-medium">
                        Analytics
                    </a>
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

// Toggle Status
document.querySelectorAll('.toggle-status').forEach(toggle => {
    toggle.addEventListener('change', async function() {
        const adId = this.dataset.adId;
        const isChecked = this.checked;
        
        try {
            const response = await fetch(`/admin/ads/${adId}/toggle-status`, {
                method: 'POST',
                headers: {
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content,
                    'Accept': 'application/json',
                    'Content-Type': 'application/json'
                }
            });

            const data = await response.json();

            if (data.success) {
                // Update status label
                const statusLabel = document.querySelector(`.status-label-${adId}`);
                if (statusLabel) {
                    statusLabel.textContent = data.is_active ? 'Active' : 'Inactive';
                    // Update label color
                    statusLabel.className = `text-xs font-semibold status-label-${adId} ${data.is_active ? 'text-green-600' : 'text-gray-500'}`;
                }
                
                // Update status badge in header
                const card = this.closest('.bg-white');
                const statusBadges = card.querySelectorAll('.px-2.py-0\\.5.text-xs');
                statusBadges.forEach(badge => {
                    const text = badge.textContent.trim().toLowerCase();
                    if (['active', 'inactive', 'expired', 'scheduled'].includes(text)) {
                        badge.textContent = data.status.charAt(0).toUpperCase() + data.status.slice(1);
                        
                        // Update badge color
                        badge.className = 'px-2 py-0.5 text-xs font-medium rounded-full';
                        if (data.status_color === 'green') {
                            badge.classList.add('bg-green-100', 'text-green-800');
                        } else if (data.status_color === 'blue') {
                            badge.classList.add('bg-blue-100', 'text-blue-800');
                        } else if (data.status_color === 'red') {
                            badge.classList.add('bg-red-100', 'text-red-800');
                        } else {
                            badge.classList.add('bg-gray-100', 'text-gray-800');
                        }
                    }
                });
                
                window.showToast('success', data.message);
            } else {
                // Revert toggle if failed
                this.checked = !isChecked;
                window.showToast('error', data.message || 'Failed to update status');
            }
        } catch (error) {
            console.error('Toggle error:', error);
            // Revert toggle if failed
            this.checked = !isChecked;
            window.showToast('error', 'Failed to update status. Please try again.');
        }
    });
});
</script>
@endpush
@endsection
