@extends('layouts.admin')

@section('title', 'Edit Menu - ' . $menu->name)
@section('page-title', 'Menu Builder: ' . $menu->name)

@section('content')
<div class="grid grid-cols-1 lg:grid-cols-3 gap-6" x-data="menuBuilder()">
    <!-- Left Sidebar - Available Items -->
    <div class="lg:col-span-1 space-y-6">
        <!-- Pages -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <button @click="toggleSection('pages')" class="w-full px-6 py-4 flex items-center justify-between bg-gradient-to-r from-blue-50 to-indigo-50 hover:from-blue-100 hover:to-indigo-100 transition-all">
                <span class="font-semibold text-gray-900">Pages</span>
                <svg class="w-5 h-5 transition-transform" :class="openSections.pages ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="openSections.pages" x-collapse class="p-4 space-y-2 max-h-64 overflow-y-auto">
                @forelse($pages as $page)
                @php
                    $isInMenu = $menu->items()->where('type', 'page')->where('target_id', $page->id)->exists();
                @endphp
                <div class="flex items-center justify-between p-3 rounded-lg transition-all {{ $isInMenu ? 'bg-green-50 border border-green-200' : 'bg-gray-50 hover:bg-gray-100' }}">
                    <div class="flex items-center gap-2 flex-1">
                        <span class="text-sm text-gray-700">{{ $page->title }}</span>
                        @if($isInMenu)
                        <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full font-medium">
                            ✓ Sudah ditambahkan
                        </span>
                        @endif
                    </div>
                    <button 
                        @click="addMenuItem('page', {{ $page->id }}, '{{ addslashes($page->title) }}', '{{ route('page.show', $page->slug) }}')" 
                        class="px-3 py-1 text-xs rounded transition-all {{ $isInMenu ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-blue-600 text-white hover:bg-blue-700' }}"
                        {{ $isInMenu ? 'disabled' : '' }}>
                        {{ $isInMenu ? 'Sudah Ada' : 'Add' }}
                    </button>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">No pages available</p>
                @endforelse
            </div>
        </div>

        <!-- Categories -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <button @click="toggleSection('categories')" class="w-full px-6 py-4 flex items-center justify-between bg-gradient-to-r from-purple-50 to-pink-50 hover:from-purple-100 hover:to-pink-100 transition-all">
                <span class="font-semibold text-gray-900">Categories</span>
                <svg class="w-5 h-5 transition-transform" :class="openSections.categories ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="openSections.categories" x-collapse class="p-4 space-y-2 max-h-64 overflow-y-auto">
                @forelse($categories as $category)
                @php
                    $isInMenu = $menu->items()->where('type', 'category')->where('target_id', $category->id)->exists();
                @endphp
                <div class="flex items-center justify-between p-3 rounded-lg transition-all {{ $isInMenu ? 'bg-green-50 border border-green-200' : 'bg-gray-50 hover:bg-gray-100' }}">
                    <div class="flex items-center gap-2 flex-1">
                        <span class="text-sm text-gray-700">{{ $category->name }}</span>
                        @if($isInMenu)
                        <span class="px-2 py-0.5 bg-green-100 text-green-700 text-xs rounded-full font-medium">
                            ✓ Sudah ditambahkan
                        </span>
                        @endif
                    </div>
                    <button 
                        @click="addMenuItem('category', {{ $category->id }}, '{{ addslashes($category->name) }}', '{{ route('blog.category', $category->slug) }}')" 
                        class="px-3 py-1 text-xs rounded transition-all {{ $isInMenu ? 'bg-gray-300 text-gray-500 cursor-not-allowed' : 'bg-purple-600 text-white hover:bg-purple-700' }}"
                        {{ $isInMenu ? 'disabled' : '' }}>
                        {{ $isInMenu ? 'Sudah Ada' : 'Add' }}
                    </button>
                </div>
                @empty
                <p class="text-sm text-gray-500 text-center py-4">No categories available</p>
                @endforelse
            </div>
        </div>

        <!-- Custom Link -->
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <button @click="toggleSection('custom')" class="w-full px-6 py-4 flex items-center justify-between bg-gradient-to-r from-green-50 to-emerald-50 hover:from-green-100 hover:to-emerald-100 transition-all">
                <span class="font-semibold text-gray-900">Custom Link</span>
                <svg class="w-5 h-5 transition-transform" :class="openSections.custom ? 'rotate-180' : ''" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </button>
            <div x-show="openSections.custom" x-collapse class="p-4 space-y-3">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Link Text</label>
                    <input type="text" x-model="customLink.title" placeholder="e.g., About Us"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">URL</label>
                    <input type="url" x-model="customLink.url" placeholder="https://example.com"
                        class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent text-sm">
                </div>
                <button @click="addCustomLink()" class="w-full px-4 py-2 bg-green-600 text-white rounded-lg hover:bg-green-700 transition-all font-medium">
                    Add Custom Link
                </button>
            </div>
        </div>
    </div>

    <!-- Right Side - Menu Structure -->
    <div class="lg:col-span-2">
        <div class="bg-white rounded-xl shadow-sm border border-gray-200 overflow-hidden">
            <div class="px-6 py-4 border-b border-gray-200 bg-gradient-to-r from-blue-50 to-indigo-50">
                <h3 class="text-lg font-semibold text-gray-900">Menu Structure</h3>
                <p class="text-sm text-gray-600 mt-1">Drag and drop to reorder menu items (auto-save)</p>
            </div>

            <div class="p-6">
                <div id="menuItems" class="space-y-2 min-h-[400px]">
                    @foreach($menu->items as $item)
                    <div class="menu-item" data-id="{{ $item->id }}" data-parent-id="{{ $item->parent_id }}">
                        <div class="flex items-center gap-3 p-4 bg-gray-50 rounded-lg border-2 border-gray-200 hover:border-blue-400 transition-all cursor-move">
                            <svg class="w-5 h-5 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                            </svg>
                            <div class="flex-1">
                                <div class="font-medium text-gray-900">{{ $item->title }}</div>
                                <div class="text-sm text-gray-500">{{ $item->url ?: $item->getUrl() }}</div>
                            </div>
                            <div class="flex items-center gap-2">
                                <span class="px-2 py-1 text-xs font-medium rounded {{ $item->is_active ? 'bg-green-100 text-green-800' : 'bg-gray-100 text-gray-800' }}">
                                    {{ $item->is_active ? 'Active' : 'Inactive' }}
                                </span>
                                <button onclick="editMenuItem({{ $item->id }})" class="p-2 text-blue-600 hover:bg-blue-50 rounded transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                    </svg>
                                </button>
                                <button onclick="deleteMenuItem({{ $item->id }}, '{{ route('admin.menus.items.destroy', [$menu, $item]) }}')" class="p-2 text-red-600 hover:bg-red-50 rounded transition-all">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                    </svg>
                                </button>
                            </div>
                        </div>

                        @if($item->children->count() > 0)
                        <div class="ml-8 mt-2 space-y-2">
                            @foreach($item->children as $child)
                            <div class="menu-item" data-id="{{ $child->id }}" data-parent-id="{{ $child->parent_id }}">
                                <div class="flex items-center gap-3 p-3 bg-white rounded-lg border-2 border-gray-200 hover:border-blue-400 transition-all cursor-move">
                                    <svg class="w-4 h-4 text-gray-400 flex-shrink-0" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 8h16M4 16h16"/>
                                    </svg>
                                    <div class="flex-1">
                                        <div class="font-medium text-gray-900 text-sm">{{ $child->title }}</div>
                                        <div class="text-xs text-gray-500">{{ $child->url ?: $child->getUrl() }}</div>
                                    </div>
                                    <div class="flex items-center gap-2">
                                        <button onclick="editMenuItem({{ $child->id }})" class="p-1.5 text-blue-600 hover:bg-blue-50 rounded transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 5H6a2 2 0 00-2 2v11a2 2 0 002 2h11a2 2 0 002-2v-5m-1.414-9.414a2 2 0 112.828 2.828L11.828 15H9v-2.828l8.586-8.586z"/>
                                            </svg>
                                        </button>
                                        <button onclick="deleteMenuItem({{ $child->id }}, '{{ route('admin.menus.items.destroy', [$menu, $child]) }}')" class="p-1.5 text-red-600 hover:bg-red-50 rounded transition-all">
                                            <svg class="w-3.5 h-3.5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 7l-.867 12.142A2 2 0 0116.138 21H7.862a2 2 0 01-1.995-1.858L5 7m5 4v6m4-6v6m1-10V4a1 1 0 00-1-1h-4a1 1 0 00-1 1v3M4 7h16"/>
                                            </svg>
                                        </button>
                                    </div>
                                </div>
                            </div>
                            @endforeach
                        </div>
                        @endif
                    </div>
                    @endforeach

                    <div x-show="menuItems.length === 0" class="text-center py-12 text-gray-500">
                        <svg class="w-16 h-16 mx-auto text-gray-300 mb-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/>
                        </svg>
                        <p>No menu items yet. Add items from the left sidebar.</p>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

@push('styles')
<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.css">
@endpush

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/sortablejs@latest/Sortable.min.js"></script>
<script>
function menuBuilder() {
    return {
        openSections: {
            pages: true,
            categories: false,
            custom: false
        },
        customLink: {
            title: '',
            url: ''
        },
        menuItems: @json($menu->items),
        sortable: null,

        init() {
            this.initSortable();
        },

        toggleSection(section) {
            this.openSections[section] = !this.openSections[section];
        },

        initSortable() {
            const el = document.getElementById('menuItems');
            this.sortable = Sortable.create(el, {
                animation: 150,
                handle: '.cursor-move',
                ghostClass: 'opacity-50',
                onEnd: (evt) => {
                    console.log('Item moved from', evt.oldIndex, 'to', evt.newIndex);
                    // Auto-save after reorder
                    this.saveMenu();
                }
            });
        },

        async addMenuItem(type, targetId, title, url) {
            // Cek apakah page/category sudah ada di menu
            if (type === 'page' || type === 'category') {
                const existingItems = document.querySelectorAll('.menu-item');
                for (const item of existingItems) {
                    const itemTitle = item.querySelector('.font-medium')?.textContent;
                    if (itemTitle === title) {
                        const itemType = type === 'page' ? 'Page' : 'Category';
                        window.showToast('warning', `${itemType} ini sudah ada di menu!`);
                        return;
                    }
                }
            }

            try {
                const response = await fetch('{{ route("admin.menus.items.store", $menu) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({
                        title: title,
                        type: type,
                        target_id: targetId,
                        url: url,
                        target: '_self',
                        is_active: true,
                        sort_order: this.menuItems.length
                    })
                });

                const data = await response.json();

                if (response.ok && data.success) {
                    window.showToast('success', data.message || 'Menu item berhasil ditambahkan!');
                    setTimeout(() => window.location.reload(), 1000);
                } else {
                    window.showToast('error', data.message || 'Gagal menambahkan menu item');
                }
            } catch (error) {
                console.error('Error adding menu item:', error);
                window.showToast('error', 'Gagal menambahkan menu item');
            }
        },

        async addCustomLink() {
            if (!this.customLink.title || !this.customLink.url) {
                alert('Please fill in both title and URL');
                return;
            }

            await this.addMenuItem('custom', null, this.customLink.title, this.customLink.url);
            this.customLink = { title: '', url: '' };
        },

        async saveMenu() {
            const items = [];
            document.querySelectorAll('.menu-item').forEach((el, index) => {
                items.push({
                    id: parseInt(el.dataset.id),
                    sort_order: index,
                    parent_id: el.dataset.parentId ? parseInt(el.dataset.parentId) : null
                });
            });

            try {
                const response = await fetch('{{ route("admin.menus.items.reorder", $menu) }}', {
                    method: 'POST',
                    headers: {
                        'Content-Type': 'application/json',
                        'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
                    },
                    body: JSON.stringify({ items })
                });

                const data = await response.json();
                
                if (data.success) {
                    window.showToast('success', 'Menu order saved successfully!');
                } else {
                    window.showToast('error', 'Failed to save menu order');
                }
            } catch (error) {
                console.error('Error saving menu:', error);
                window.showToast('error', 'Failed to save menu: ' + error.message);
            }
        }
    }
}

async function deleteMenuItem(id, deleteUrl) {
    const confirmed = await window.confirmDelete('Delete Menu Item', 'Are you sure you want to delete this menu item?');
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
            window.showToast('success', 'Menu item berhasil dihapus!');
            setTimeout(() => window.location.reload(), 1000);
        } else {
            window.showToast('error', 'Delete failed. Please try again.');
        }
    } catch (error) {
        console.error('Delete error:', error);
        window.showToast('error', 'Delete failed. Please try again.');
    }
}
</script>
@endpush
@endsection
