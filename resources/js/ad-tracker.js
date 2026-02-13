/**
 * Ad Tracker - Track ad impressions and clicks
 */

class AdTracker {
    constructor() {
        this.trackedImpressions = new Set();
        this.init();
    }

    init() {
        // Track impressions on page load
        this.trackVisibleAds();

        // Track impressions on scroll (for lazy loaded ads)
        window.addEventListener('scroll', this.debounce(() => {
            this.trackVisibleAds();
        }, 500));

        // Track clicks
        this.attachClickTrackers();
    }

    /**
     * Track visible ads (impressions)
     */
    trackVisibleAds() {
        const ads = document.querySelectorAll('[data-ad-id]');
        
        ads.forEach(ad => {
            const adId = ad.dataset.adId;
            
            // Skip if already tracked
            if (this.trackedImpressions.has(adId)) {
                return;
            }

            // Check if ad is visible in viewport
            if (this.isElementInViewport(ad)) {
                this.trackImpression(adId);
                this.trackedImpressions.add(adId);
            }
        });
    }

    /**
     * Track ad impression
     */
    trackImpression(adId) {
        const data = {
            ad_id: adId,
            page_url: window.location.href,
            page_type: this.getPageType(),
        };

        this.sendTrackingRequest('/api/ads/track-impression', data);
    }

    /**
     * Attach click trackers to all ads
     */
    attachClickTrackers() {
        const ads = document.querySelectorAll('[data-ad-id]');
        
        ads.forEach(ad => {
            // Track clicks on the ad container
            ad.addEventListener('click', (e) => {
                const adId = ad.dataset.adId;
                this.trackClick(adId);
            });

            // Track clicks on links inside ads
            const links = ad.querySelectorAll('a');
            links.forEach(link => {
                link.addEventListener('click', (e) => {
                    const adId = ad.dataset.adId;
                    this.trackClick(adId);
                });
            });
        });
    }

    /**
     * Track ad click
     */
    trackClick(adId) {
        const data = {
            ad_id: adId,
            page_url: window.location.href,
            page_type: this.getPageType(),
        };

        this.sendTrackingRequest('/api/ads/track-click', data);
    }

    /**
     * Send tracking request to server
     */
    sendTrackingRequest(url, data) {
        // Use sendBeacon for better reliability (works even when page is closing)
        if (navigator.sendBeacon) {
            const blob = new Blob([JSON.stringify(data)], { type: 'application/json' });
            navigator.sendBeacon(url, blob);
        } else {
            // Fallback to fetch
            fetch(url, {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.content || '',
                },
                body: JSON.stringify(data),
                keepalive: true, // Keep request alive even if page is closing
            }).catch(err => {
                console.error('Ad tracking error:', err);
            });
        }
    }

    /**
     * Check if element is in viewport
     */
    isElementInViewport(el) {
        const rect = el.getBoundingClientRect();
        return (
            rect.top >= 0 &&
            rect.left >= 0 &&
            rect.bottom <= (window.innerHeight || document.documentElement.clientHeight) &&
            rect.right <= (window.innerWidth || document.documentElement.clientWidth)
        );
    }

    /**
     * Get page type from URL
     */
    getPageType() {
        const path = window.location.pathname;
        
        if (path === '/') return 'home';
        if (path === '/blog') return 'blog_index';
        if (path.startsWith('/blog/')) return 'blog_detail';
        if (path.startsWith('/category/')) return 'blog_category';
        if (path.startsWith('/tag/')) return 'blog_tag';
        if (path === '/contact') return 'contact';
        if (path === '/about') return 'about';
        
        return 'static_page';
    }

    /**
     * Debounce function
     */
    debounce(func, wait) {
        let timeout;
        return function executedFunction(...args) {
            const later = () => {
                clearTimeout(timeout);
                func(...args);
            };
            clearTimeout(timeout);
            timeout = setTimeout(later, wait);
        };
    }
}

// Initialize tracker when DOM is ready
if (document.readyState === 'loading') {
    document.addEventListener('DOMContentLoaded', () => {
        new AdTracker();
    });
} else {
    new AdTracker();
}
