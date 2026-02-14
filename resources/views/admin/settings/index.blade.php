@extends('layouts.admin')

@section('title', 'Settings')
@section('page-title', 'Site Settings')

@push('styles')
<style>
/* Modern Tab Styles */
.settings-tabs {
    background: linear-gradient(to bottom, #ffffff 0%, #f8fafc 100%);
}

.tab-nav {
    display: flex;
    gap: 0.5rem;
    padding: 1rem;
    overflow-x: auto;
    scrollbar-width: none;
    -ms-overflow-style: none;
}

.tab-nav::-webkit-scrollbar {
    display: none;
}

.tab-item {
    position: relative;
    display: flex;
    align-items: center;
    gap: 0.75rem;
    padding: 1rem 1.5rem;
    background: white;
    border: 2px solid #e5e7eb;
    border-radius: 1rem;
    cursor: pointer;
    transition: all 0.3s cubic-bezier(0.4, 0, 0.2, 1);
    white-space: nowrap;
    min-width: fit-content;
}

.tab-item:hover {
    border-color: #3b82f6;
    transform: translateY(-2px);
    box-shadow: 0 4px 12px rgba(59, 130, 246, 0.15);
}

.tab-item.active {
    background: linear-gradient(135deg, #3b82f6 0%, #2563eb 100%);
    border-color: #3b82f6;
    color: white;
    box-shadow: 0 8px 16px rgba(59, 130, 246, 0.3);
}

.tab-icon {
    width: 2.5rem;
    height: 2.5rem;
    display: flex;
    align-items: center;
    justify-content: center;
    border-radius: 0.75rem;
    transition: all 0.3s ease;
    flex-shrink: 0;
}

.tab-item:not(.active) .tab-icon {
    background: #f3f4f6;
}

.tab-item.active .tab-icon {
    background: rgba(255, 255, 255, 0.2);
}

.tab-icon svg {
    width: 1.25rem;
    height: 1.25rem;
    display: block;
    margin: auto;
}

.tab-item:not(.active) .tab-icon svg {
    color: #6b7280;
}

.tab-item.active .tab-icon svg {
    color: white;
}

.tab-label {
    display: flex;
    flex-direction: column;
    gap: 0.125rem;
}

.tab-title {
    font-size: 0.875rem;
    font-weight: 600;
    line-height: 1.25;
}

.tab-item:not(.active) .tab-title {
    color: #1f2937;
}

.tab-item.active .tab-title {
    color: white;
}

.tab-subtitle {
    font-size: 0.75rem;
    line-height: 1;
}

.tab-item:not(.active) .tab-subtitle {
    color: #9ca3af;
}

.tab-item.active .tab-subtitle {
    color: rgba(255, 255, 255, 0.8);
}

/* Tab Content Animation */
.tab-content {
    display: none;
    animation: slideUp 0.4s cubic-bezier(0.4, 0, 0.2, 1);
}

.tab-content.active {
    display: block;
}

@keyframes slideUp {
    from {
        opacity: 0;
        transform: translateY(20px);
    }
    to {
        opacity: 1;
        transform: translateY(0);
    }
}

/* Premium Card Style */
.settings-card {
    background: white;
    border-radius: 1.5rem;
    box-shadow: 0 1px 3px rgba(0, 0, 0, 0.05);
    border: 1px solid #e5e7eb;
}

.settings-card-header {
    padding: 1.5rem 2rem;
    border-bottom: 1px solid #f3f4f6;
}

.settings-card-body {
    padding: 2rem;
}
</style>
@endpush

@section('content')
<!-- Page Header -->
<div class="mb-8">
    <div class="flex items-center justify-between">
        <div>
            <h1 class="text-3xl font-bold text-gray-900 mb-2">Settings</h1>
            <p class="text-gray-600">Manage your website configuration and preferences</p>
        </div>
        <div class="flex items-center gap-2 px-4 py-2 bg-blue-50 text-blue-700 rounded-xl text-sm font-medium">
            <svg class="w-4 h-4" fill="currentColor" viewBox="0 0 20 20">
                <path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"/>
            </svg>
            All changes auto-saved
        </div>
    </div>
</div>

<!-- Modern Tabs Navigation -->
<div class="settings-tabs rounded-2xl shadow-sm border border-gray-200 mb-6">
    <div class="tab-nav">
        <button type="button" onclick="switchTab('general')" class="tab-item active" data-tab="general">
            <div class="tab-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z"/>
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/>
                </svg>
            </div>
            <div class="tab-label">
                <span class="tab-title">General</span>
                <span class="tab-subtitle">Basic information</span>
            </div>
        </button>
        
        <button type="button" onclick="switchTab('branding')" class="tab-item" data-tab="branding">
            <div class="tab-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21a4 4 0 01-4-4V5a2 2 0 012-2h4a2 2 0 012 2v12a4 4 0 01-4 4zm0 0h12a2 2 0 002-2v-4a2 2 0 00-2-2h-2.343M11 7.343l1.657-1.657a2 2 0 012.828 0l2.829 2.829a2 2 0 010 2.828l-8.486 8.485M7 17h.01"/>
                </svg>
            </div>
            <div class="tab-label">
                <span class="tab-title">Branding</span>
                <span class="tab-subtitle">Logo & identity</span>
            </div>
        </button>
        
        <button type="button" onclick="switchTab('template')" class="tab-item" data-tab="template">
            <div class="tab-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 5a1 1 0 011-1h14a1 1 0 011 1v2a1 1 0 01-1 1H5a1 1 0 01-1-1V5zM4 13a1 1 0 011-1h6a1 1 0 011 1v6a1 1 0 01-1 1H5a1 1 0 01-1-1v-6zM16 13a1 1 0 011-1h2a1 1 0 011 1v6a1 1 0 01-1 1h-2a1 1 0 01-1-1v-6z"/>
                </svg>
            </div>
            <div class="tab-label">
                <span class="tab-title">Template</span>
                <span class="tab-subtitle">Design theme</span>
            </div>
        </button>
        
        <button type="button" onclick="switchTab('seo')" class="tab-item" data-tab="seo">
            <div class="tab-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M21 21l-6-6m2-5a7 7 0 11-14 0 7 7 0 0114 0z"/>
                </svg>
            </div>
            <div class="tab-label">
                <span class="tab-title">SEO</span>
                <span class="tab-subtitle">Search optimization</span>
            </div>
        </button>
        
        <button type="button" onclick="switchTab('hero')" class="tab-item" data-tab="hero">
            <div class="tab-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 16l4.586-4.586a2 2 0 012.828 0L16 16m-2-2l1.586-1.586a2 2 0 012.828 0L20 14m-6-6h.01M6 20h12a2 2 0 002-2V6a2 2 0 00-2-2H6a2 2 0 00-2 2v12a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="tab-label">
                <span class="tab-title">Hero Section</span>
                <span class="tab-subtitle">Landing content</span>
            </div>
        </button>
        
        <button type="button" onclick="switchTab('social')" class="tab-item" data-tab="social">
            <div class="tab-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 8h2a2 2 0 012 2v6a2 2 0 01-2 2h-2v4l-4-4H9a1.994 1.994 0 01-1.414-.586m0 0L11 14h4a2 2 0 002-2V6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2v4l.586-.586z"/>
                </svg>
            </div>
            <div class="tab-label">
                <span class="tab-title">Social Media</span>
                <span class="tab-subtitle">Links & WhatsApp</span>
            </div>
        </button>
        
        <button type="button" onclick="switchTab('footer')" class="tab-item" data-tab="footer">
            <div class="tab-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7"/>
                </svg>
            </div>
            <div class="tab-label">
                <span class="tab-title">Footer</span>
                <span class="tab-subtitle">Copyright & about</span>
            </div>
        </button>
        
        <button type="button" onclick="switchTab('about')" class="tab-item" data-tab="about">
            <div class="tab-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="tab-label">
                <span class="tab-title">About Statistics</span>
                <span class="tab-subtitle">Stats & numbers</span>
            </div>
        </button>
        
        <button type="button" onclick="switchTab('mail')" class="tab-item" data-tab="mail">
            <div class="tab-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/>
                </svg>
            </div>
            <div class="tab-label">
                <span class="tab-title">Mail</span>
                <span class="tab-subtitle">SMTP configuration</span>
            </div>
        </button>
        
        <button type="button" onclick="switchTab('analytics')" class="tab-item" data-tab="analytics">
            <div class="tab-icon">
                <svg fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/>
                </svg>
            </div>
            <div class="tab-label">
                <span class="tab-title">Analytics</span>
                <span class="tab-subtitle">Google GA4</span>
            </div>
        </button>
    </div>
</div>

<!-- Tab Contents -->
<div id="tabContents">
    @include('admin.settings.tabs.general')
    @include('admin.settings.tabs.branding')
    @include('admin.settings.tabs.template')
    @include('admin.settings.tabs.seo')
    @include('admin.settings.tabs.hero')
    @include('admin.settings.tabs.social')
    @include('admin.settings.tabs.footer')
    @include('admin.settings.tabs.about')
    @include('admin.settings.tabs.mail')
    @include('admin.settings.tabs.analytics')
</div>

@push('scripts')
<script>
function switchTab(tabName) {
    // Hide all tab contents with fade out
    document.querySelectorAll('.tab-content').forEach(content => {
        content.classList.remove('active');
    });
    
    // Remove active class from all buttons
    document.querySelectorAll('.tab-item').forEach(button => {
        button.classList.remove('active');
    });
    
    // Show selected tab content with fade in
    const targetContent = document.getElementById(tabName + '-tab');
    if (targetContent) {
        targetContent.classList.add('active');
    }
    
    // Add active class to clicked button
    const activeButton = document.querySelector(`[data-tab="${tabName}"]`);
    if (activeButton) {
        activeButton.classList.add('active');
        
        // Smooth scroll to button if needed
        activeButton.scrollIntoView({ behavior: 'smooth', block: 'nearest', inline: 'center' });
    }
}

// Initialize first tab
document.addEventListener('DOMContentLoaded', function() {
    switchTab('general');
});
</script>
@endpush
@endsection
