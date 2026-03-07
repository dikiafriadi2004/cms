/**
 * Blog Filter with AJAX
 * Handles category filtering and search without page reload
 */

(function() {
    'use strict';

    // Configuration
    const config = {
        postsContainer: '#posts-container',
        paginationContainer: '#pagination-container',
        categoryButtons: '.category-filter-btn',
        searchInput: '#blog-search',
        loadingClass: 'loading',
        activeClass: 'active',
    };

    // State
    let currentCategory = null;
    let currentSearch = '';
    let isLoading = false;

    /**
     * Initialize the blog filter
     */
    function init() {
        setupCategoryFilters();
        setupSearchFilter();
        setupPagination();
        
        // No URL params - always start fresh
        currentCategory = null;
        currentSearch = '';
    }

    /**
     * Setup category filter buttons
     */
    function setupCategoryFilters() {
        const categoryButtons = document.querySelectorAll(config.categoryButtons);
        
        categoryButtons.forEach(button => {
            button.addEventListener('click', function(e) {
                e.preventDefault();
                
                if (isLoading) return;
                
                const category = this.dataset.category;
                
                // Set category (no toggle - always set)
                currentCategory = category;
                setActiveCategoryButton(category);
                
                // Load posts (URL stays the same)
                loadPosts();
            });
        });
    }

    /**
     * Setup search filter
     */
    function setupSearchFilter() {
        const searchInput = document.querySelector(config.searchInput);
        
        if (!searchInput) return;
        
        let searchTimeout;
        
        searchInput.addEventListener('input', function() {
            clearTimeout(searchTimeout);
            
            searchTimeout = setTimeout(() => {
                currentSearch = this.value.trim();
                loadPosts(); // URL stays the same
            }, 500); // Debounce 500ms
        });
    }

    /**
     * Setup pagination click handler
     */
    function setupPagination() {
        document.addEventListener('click', function(e) {
            const paginationLink = e.target.closest('.pagination a');
            
            if (paginationLink && !paginationLink.classList.contains('disabled')) {
                e.preventDefault();
                
                const url = new URL(paginationLink.href);
                const page = url.searchParams.get('page');
                
                if (page) {
                    loadPosts(page);
                    
                    // Scroll to top of posts
                    const postsContainer = document.querySelector(config.postsContainer);
                    if (postsContainer) {
                        postsContainer.scrollIntoView({ behavior: 'smooth', block: 'start' });
                    }
                }
            }
        });
    }

    /**
     * Load posts via AJAX
     */
    function loadPosts(page = 1) {
        if (isLoading) return;
        
        isLoading = true;
        showLoading();
        
        // Build URL
        const params = new URLSearchParams();
        if (currentCategory) params.append('category', currentCategory);
        if (currentSearch) params.append('search', currentSearch);
        if (page > 1) params.append('page', page);
        
        const url = `/blog?${params.toString()}`;
        
        // Fetch posts
        fetch(url, {
            headers: {
                'X-Requested-With': 'XMLHttpRequest',
                'Accept': 'application/json',
            }
        })
        .then(response => {
            if (!response.ok) throw new Error('Network response was not ok');
            return response.json();
        })
        .then(data => {
            updatePostsContainer(data.html);
            updatePaginationContainer(data.pagination);
            updateResultsCount(data.total);
            hideLoading();
            isLoading = false;
        })
        .catch(error => {
            console.error('Error loading posts:', error);
            showError();
            hideLoading();
            isLoading = false;
        });
    }

    /**
     * Update posts container
     */
    function updatePostsContainer(html) {
        const container = document.querySelector(config.postsContainer);
        if (container) {
            container.innerHTML = html;
            
            // Trigger animation
            container.classList.add('fade-in');
            setTimeout(() => container.classList.remove('fade-in'), 300);
        }
    }

    /**
     * Update pagination container
     */
    function updatePaginationContainer(html) {
        const container = document.querySelector(config.paginationContainer);
        if (container) {
            container.innerHTML = html;
        }
    }

    /**
     * Update results count
     */
    function updateResultsCount(total) {
        const countElement = document.querySelector('#results-count');
        if (countElement) {
            countElement.textContent = `${total} post${total !== 1 ? 's' : ''} found`;
        }
    }

    /**
     * Update URL without reload (DISABLED - URL stays the same)
     */
    function updateURL() {
        // URL tetap sama, tidak ada perubahan
        // Data berubah tapi URL tetap /blog
        return;
    }

    /**
     * Set active category button
     */
    function setActiveCategoryButton(category) {
        // Remove active class from all buttons
        removeActiveCategoryButton();
        
        // Find and activate the clicked button
        const button = document.querySelector(`${config.categoryButtons}[data-category="${category}"]`);
        if (button) {
            // Remove default classes
            button.classList.remove('bg-white', 'text-slate-600', 'border', 'border-slate-200');
            
            // Add active classes - using inline style for guaranteed color
            button.classList.add('text-white', 'font-bold');
            button.style.backgroundColor = '#3b82f6'; // blue-600
            button.style.boxShadow = '0 10px 25px -5px rgba(59, 130, 246, 0.3)';
            button.style.border = 'none';
            button.classList.add(config.activeClass);
        }
    }

    /**
     * Remove active class from all category buttons
     */
    function removeActiveCategoryButton() {
        const buttons = document.querySelectorAll(config.categoryButtons);
        buttons.forEach(btn => {
            // Remove active class
            btn.classList.remove(config.activeClass);
            
            // Remove inline styles
            btn.style.backgroundColor = '';
            btn.style.boxShadow = '';
            btn.style.border = '';
            
            // Remove active styles
            btn.classList.remove('text-white');
            
            // Add default styles
            btn.classList.add('bg-white', 'text-slate-600', 'border', 'border-slate-200');
        });
    }

    /**
     * Show loading state
     */
    function showLoading() {
        const container = document.querySelector(config.postsContainer);
        if (container) {
            container.classList.add(config.loadingClass);
            container.style.opacity = '0.5';
            container.style.pointerEvents = 'none';
        }
    }

    /**
     * Hide loading state
     */
    function hideLoading() {
        const container = document.querySelector(config.postsContainer);
        if (container) {
            container.classList.remove(config.loadingClass);
            container.style.opacity = '1';
            container.style.pointerEvents = 'auto';
        }
    }

    /**
     * Show error message
     */
    function showError() {
        const container = document.querySelector(config.postsContainer);
        if (container) {
            container.innerHTML = `
                <div class="col-span-full text-center py-12">
                    <svg class="mx-auto h-12 w-12 text-red-400" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 8v4m0 4h.01M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                    </svg>
                    <h3 class="mt-2 text-sm font-medium text-gray-900">Error loading posts</h3>
                    <p class="mt-1 text-sm text-gray-500">Please try again later.</p>
                </div>
            `;
        }
    }

    // Initialize when DOM is ready
    if (document.readyState === 'loading') {
        document.addEventListener('DOMContentLoaded', init);
    } else {
        init();
    }

})();
