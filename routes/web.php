<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\MenuController;
use App\Http\Controllers\Admin\MediaController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\AdController;
use App\Http\Controllers\Admin\ContactController as AdminContactController;
use App\Http\Controllers\Admin\ProfileController;
use App\Http\Controllers\Frontend\HomeController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Frontend\ContactController;
use App\Http\Controllers\SitemapController;
use App\Http\Controllers\Admin\AdAnalyticsController;

// Auth Routes - HARUS DI ATAS
require __DIR__.'/auth.php';

// SEO Routes
Route::get('/sitemap.xml', [SitemapController::class, 'index'])->name('sitemap');
Route::get('/robots.txt', [SitemapController::class, 'robots'])->name('robots');

// Ads Tracking API (Public - No Auth Required)
Route::post('/api/ads/track-impression', [AdAnalyticsController::class, 'trackImpression'])->name('api.ads.track-impression');
Route::post('/api/ads/track-click', [AdAnalyticsController::class, 'trackClick'])->name('api.ads.track-click');

// Frontend Routes
Route::get('/', [HomeController::class, 'index'])->name('home');

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{post:slug}', [BlogController::class, 'show'])->name('blog.show');
Route::get('/category/{category}', [BlogController::class, 'category'])->name('blog.category');
Route::get('/tag/{tag}', [BlogController::class, 'tag'])->name('blog.tag');

// Contact Routes
Route::get('/contact', [ContactController::class, 'show'])->name('contact.show');
Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

// About Us Route
Route::get('/about', [HomeController::class, 'about'])->name('about');

// Admin Routes
Route::prefix('admin')->name('admin.')->middleware(['auth'])->group(function () {
    // Dashboard
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard')->middleware('permission:dashboard.view');
    
    // Profile - Available for all authenticated users
    Route::get('profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::put('profile/password', [ProfileController::class, 'updatePassword'])->name('profile.password.update');
    
    // Posts
    Route::get('posts/create', [PostController::class, 'create'])->name('posts.create')->middleware('permission:posts.create');
    Route::middleware('permission:posts.view')->group(function () {
        Route::get('posts', [PostController::class, 'index'])->name('posts.index');
        Route::get('posts/{post}', [PostController::class, 'show'])->name('posts.show');
    });
    Route::post('posts', [PostController::class, 'store'])->name('posts.store')->middleware('permission:posts.create');
    Route::get('posts/{post}/edit', [PostController::class, 'edit'])->name('posts.edit')->middleware('permission:posts.edit|posts.edit.own');
    Route::put('posts/{post}', [PostController::class, 'update'])->name('posts.update')->middleware('permission:posts.edit|posts.edit.own');
    Route::delete('posts/{post}', [PostController::class, 'destroy'])->name('posts.destroy')->middleware('permission:posts.delete|posts.delete.own');
    Route::post('posts/bulk-action', [PostController::class, 'bulkAction'])->name('posts.bulk-action')->middleware('permission:posts.delete');
    
    // Categories
    Route::get('categories/create', [CategoryController::class, 'create'])->name('categories.create')->middleware('permission:categories.create');
    Route::middleware('permission:categories.view')->group(function () {
        Route::get('categories', [CategoryController::class, 'index'])->name('categories.index');
        Route::get('categories/{category}', [CategoryController::class, 'show'])->name('categories.show');
    });
    Route::post('categories', [CategoryController::class, 'store'])->name('categories.store')->middleware('permission:categories.create');
    Route::get('categories/{category}/edit', [CategoryController::class, 'edit'])->name('categories.edit')->middleware('permission:categories.edit');
    Route::put('categories/{category}', [CategoryController::class, 'update'])->name('categories.update')->middleware('permission:categories.edit');
    Route::delete('categories/{category}', [CategoryController::class, 'destroy'])->name('categories.destroy')->middleware('permission:categories.delete');
    
    // Tags
    Route::get('tags/create', [TagController::class, 'create'])->name('tags.create')->middleware('permission:tags.create');
    Route::get('tags/search', [TagController::class, 'search'])->name('tags.search')->middleware('permission:tags.view');
    Route::middleware('permission:tags.view')->group(function () {
        Route::get('tags', [TagController::class, 'index'])->name('tags.index');
    });
    Route::post('tags', [TagController::class, 'store'])->name('tags.store')->middleware('permission:tags.create');
    Route::get('tags/{tag}/edit', [TagController::class, 'edit'])->name('tags.edit')->middleware('permission:tags.edit');
    Route::put('tags/{tag}', [TagController::class, 'update'])->name('tags.update')->middleware('permission:tags.edit');
    Route::delete('tags/{tag}', [TagController::class, 'destroy'])->name('tags.destroy')->middleware('permission:tags.delete');
    
    // Pages
    Route::get('pages/create', [PageController::class, 'create'])->name('pages.create')->middleware('permission:pages.create');
    Route::middleware('permission:pages.view')->group(function () {
        Route::get('pages', [PageController::class, 'index'])->name('pages.index');
        Route::get('pages/{page}', [PageController::class, 'show'])->name('pages.show');
    });
    Route::post('pages', [PageController::class, 'store'])->name('pages.store')->middleware('permission:pages.create');
    Route::get('pages/{page}/edit', [PageController::class, 'edit'])->name('pages.edit')->middleware('permission:pages.edit|pages.edit.own');
    Route::put('pages/{page}', [PageController::class, 'update'])->name('pages.update')->middleware('permission:pages.edit|pages.edit.own');
    Route::delete('pages/{page}', [PageController::class, 'destroy'])->name('pages.destroy')->middleware('permission:pages.delete|pages.delete.own');
    
    // Menus
    Route::get('menus/create', [MenuController::class, 'create'])->name('menus.create')->middleware('permission:menus.create');
    Route::middleware('permission:menus.view')->group(function () {
        Route::get('menus', [MenuController::class, 'index'])->name('menus.index');
        Route::get('menus/{menu}', [MenuController::class, 'show'])->name('menus.show');
    });
    Route::post('menus', [MenuController::class, 'store'])->name('menus.store')->middleware('permission:menus.create');
    Route::get('menus/{menu}/edit', [MenuController::class, 'edit'])->name('menus.edit')->middleware('permission:menus.edit');
    Route::put('menus/{menu}', [MenuController::class, 'update'])->name('menus.update')->middleware('permission:menus.edit');
    Route::delete('menus/{menu}', [MenuController::class, 'destroy'])->name('menus.destroy')->middleware('permission:menus.delete');
    Route::post('menus/{menu}/items', [MenuController::class, 'storeItem'])->name('menus.items.store')->middleware('permission:menus.items.manage');
    Route::put('menus/{menu}/items/{item}', [MenuController::class, 'updateItem'])->name('menus.items.update')->middleware('permission:menus.items.manage');
    Route::delete('menus/{menu}/items/{item}', [MenuController::class, 'destroyItem'])->name('menus.items.destroy')->middleware('permission:menus.items.manage');
    Route::post('menus/{menu}/items/reorder', [MenuController::class, 'reorderItems'])->name('menus.items.reorder')->middleware('permission:menus.items.manage');
    
    // Media
    Route::middleware('permission:media.view')->group(function () {
        Route::get('media', [MediaController::class, 'index'])->name('media.index');
        Route::get('media/{media}', [MediaController::class, 'show'])->name('media.show');
        Route::get('media-browse', [MediaController::class, 'browse'])->name('media.browse');
    });
    Route::post('media/upload', [MediaController::class, 'upload'])->name('media.upload')->middleware('permission:media.upload');
    Route::put('media/{media}', [MediaController::class, 'update'])->name('media.update')->middleware('permission:media.edit');
    Route::delete('media/{media}', [MediaController::class, 'destroy'])->name('media.destroy')->middleware('permission:media.delete');
    Route::post('media/create-folder', [MediaController::class, 'createFolder'])->name('media.create-folder')->middleware('permission:media.upload');
    
    // Users
    Route::get('users/create', [UserController::class, 'create'])->name('users.create')->middleware('permission:users.create');
    Route::middleware('permission:users.view')->group(function () {
        Route::get('users', [UserController::class, 'index'])->name('users.index');
    });
    Route::post('users', [UserController::class, 'store'])->name('users.store')->middleware('permission:users.create');
    Route::get('users/{user}/edit', [UserController::class, 'edit'])->name('users.edit')->middleware('permission:users.edit');
    Route::put('users/{user}', [UserController::class, 'update'])->name('users.update')->middleware('permission:users.edit');
    Route::delete('users/{user}', [UserController::class, 'destroy'])->name('users.destroy')->middleware('permission:users.delete');
    Route::post('users/{user}/toggle-status', [UserController::class, 'toggleStatus'])->name('users.toggle-status')->middleware('permission:users.toggle.status');
    
    // Roles & Permissions
    Route::get('roles/create', [\App\Http\Controllers\Admin\RoleController::class, 'create'])->name('roles.create')->middleware('permission:roles.create');
    Route::middleware('permission:roles.view')->group(function () {
        Route::get('roles', [\App\Http\Controllers\Admin\RoleController::class, 'index'])->name('roles.index');
        Route::get('roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'show'])->name('roles.show');
    });
    Route::post('roles', [\App\Http\Controllers\Admin\RoleController::class, 'store'])->name('roles.store')->middleware('permission:roles.create');
    Route::get('roles/{role}/edit', [\App\Http\Controllers\Admin\RoleController::class, 'edit'])->name('roles.edit')->middleware('permission:roles.edit');
    Route::put('roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'update'])->name('roles.update')->middleware('permission:roles.edit');
    Route::delete('roles/{role}', [\App\Http\Controllers\Admin\RoleController::class, 'destroy'])->name('roles.destroy')->middleware('permission:roles.delete');
    
    Route::middleware('permission:permissions.view')->group(function () {
        Route::get('permissions', [\App\Http\Controllers\Admin\PermissionController::class, 'index'])->name('permissions.index');
    });
    
    // Settings
    Route::middleware('permission:settings.view')->group(function () {
        Route::get('settings', [SettingController::class, 'index'])->name('settings.index');
        Route::get('settings/template-preview/{template}', [SettingController::class, 'templatePreview'])->name('settings.template-preview');
    });
    Route::post('settings', [SettingController::class, 'update'])->name('settings.update')->middleware('permission:settings.edit');
    Route::delete('settings/analytics/credentials', [SettingController::class, 'deleteAnalyticsCredentials'])->name('settings.analytics.delete-credentials')->middleware('permission:settings.edit');
    Route::post('settings/analytics/test', [SettingController::class, 'testAnalyticsCredentials'])->name('settings.analytics.test')->middleware('permission:settings.view');
    
    // Ads
    Route::get('ads/create', [AdController::class, 'create'])->name('ads.create')->middleware('permission:ads.create');
    Route::middleware('permission:ads.view')->group(function () {
        Route::get('ads', [AdController::class, 'index'])->name('ads.index');
    });
    Route::post('ads', [AdController::class, 'store'])->name('ads.store')->middleware('permission:ads.create');
    Route::get('ads/{ad}/edit', [AdController::class, 'edit'])->name('ads.edit')->middleware('permission:ads.edit');
    Route::put('ads/{ad}', [AdController::class, 'update'])->name('ads.update')->middleware('permission:ads.edit');
    Route::post('ads/{ad}/toggle-status', [AdController::class, 'toggleStatus'])->name('ads.toggle-status')->middleware('permission:ads.edit');
    Route::delete('ads/{ad}', [AdController::class, 'destroy'])->name('ads.destroy')->middleware('permission:ads.delete');
    
    // Ads Analytics
    Route::middleware('permission:ads.view')->group(function () {
        Route::get('ads/analytics', [\App\Http\Controllers\Admin\AdAnalyticsController::class, 'index'])->name('ads.analytics.index');
        Route::get('ads/{ad}/analytics', [\App\Http\Controllers\Admin\AdAnalyticsController::class, 'show'])->name('ads.analytics.show');
    });
    
    // Contacts
    Route::middleware('permission:contacts.view')->group(function () {
        Route::get('contacts', [AdminContactController::class, 'index'])->name('contacts.index');
        Route::get('contacts/{contact}', [AdminContactController::class, 'show'])->name('contacts.show');
        Route::patch('contacts/{contact}/status', [AdminContactController::class, 'updateStatus'])->name('contacts.update-status');
    });
    Route::post('contacts/{contact}/reply', [AdminContactController::class, 'sendReply'])->name('contacts.send-reply')->middleware('permission:contacts.view');
    Route::delete('contacts/{contact}', [AdminContactController::class, 'destroy'])->name('contacts.destroy')->middleware('permission:contacts.delete');
    Route::post('contacts/bulk-delete', [AdminContactController::class, 'bulkDelete'])->name('contacts.bulk-delete')->middleware('permission:contacts.delete');
});

// Catch-all route untuk pages - HARUS DI PALING BAWAH
Route::get('/{page}', [HomeController::class, 'page'])->name('page.show');