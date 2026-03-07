<div class="mb-8">
    <div class="flex items-center justify-between mb-4">
        <h3 class="text-lg font-semibold text-gray-900">Categories</h3>
        <span id="results-count" class="text-sm text-gray-600">
            {{ $posts->total() }} post{{ $posts->total() !== 1 ? 's' : '' }} found
        </span>
    </div>
    
    <div class="flex flex-wrap gap-2">
        <!-- All Posts Button -->
        <button 
            class="category-filter-btn px-4 py-2 rounded-full border-2 border-gray-300 text-gray-700 hover:border-blue-500 hover:text-blue-600 transition-all duration-200 {{ !isset($selectedCategory) ? 'active border-blue-500 text-blue-600 bg-blue-50' : '' }}"
            data-category="">
            All Posts
        </button>
        
        <!-- Category Buttons -->
        @foreach($categories as $category)
            <button 
                class="category-filter-btn px-4 py-2 rounded-full border-2 border-gray-300 text-gray-700 hover:border-blue-500 hover:text-blue-600 transition-all duration-200 {{ isset($selectedCategory) && $selectedCategory->id === $category->id ? 'active border-blue-500 text-blue-600 bg-blue-50' : '' }}"
                data-category="{{ $category->slug }}">
                {{ $category->name }}
                <span class="ml-1 text-xs text-gray-500">({{ $category->published_posts_count }})</span>
            </button>
        @endforeach
    </div>
</div>

<style>
    .category-filter-btn.active {
        border-color: #3b82f6;
        color: #3b82f6;
        background-color: #eff6ff;
        font-weight: 600;
    }
    
    .category-filter-btn:hover {
        transform: translateY(-1px);
        box-shadow: 0 2px 4px rgba(0, 0, 0, 0.1);
    }
    
    #posts-container.loading {
        position: relative;
    }
    
    #posts-container.loading::after {
        content: '';
        position: absolute;
        top: 50%;
        left: 50%;
        transform: translate(-50%, -50%);
        width: 40px;
        height: 40px;
        border: 4px solid #f3f4f6;
        border-top-color: #3b82f6;
        border-radius: 50%;
        animation: spin 0.8s linear infinite;
    }
    
    @keyframes spin {
        to { transform: translate(-50%, -50%) rotate(360deg); }
    }
    
    .fade-in {
        animation: fadeIn 0.3s ease-in;
    }
    
    @keyframes fadeIn {
        from { opacity: 0; transform: translateY(10px); }
        to { opacity: 1; transform: translateY(0); }
    }
</style>
