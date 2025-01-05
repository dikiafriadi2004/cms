<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\CmsPageController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\MenuController;

Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'detail'])->name('blog.detail');


Route::middleware(['auth', 'verified', 'blocked'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->group(function (){
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');

        Route::prefix('blog')->group(function () {
            //
            Route::resource('posts', PostController::class)->middleware(['role_or_permission:Admin Posts']);
            Route::resource('categories', CategoryController::class)->middleware(['role_or_permission:Admin Categories']);
        });
        Route::resource('cms', CmsPageController::class)->names('admin.cms')->parameters(['cms' => 'id']);
        Route::resource('menu', MenuController::class)->names('admin.menu')->parameters(['menu' => 'id']);
        Route::post('/admin/menu/update-order', [MenuController::class, 'updateOrderBy'])->name('admin.menu.order');
        Route::patch('admin/menu/{id}/update-order', [MenuController::class, 'updateOrder'])->name('admin.menu.updateOrder');
        Route::patch('admin/menu/{id}/toggle-active', [MenuController::class, 'toggleActive'])->name('admin.menu.toggleActive');
        Route::resource('pages', PageController::class)->middleware(['role_or_permission:Admin Pages']);

        Route::resource('users', UserController::class)->middleware(['role_or_permission:Admin Users']);
        Route::get('users/{user}/toggle-block', [UserController::class, 'toggleBlock'])->name('users.toggle-block')->middleware(['role_or_permission:Admin Users']);

    });
});

require __DIR__.'/auth.php';


Route::get('/', [HomepageController::class, 'index'])->name('home.index');
Route::get('/{slug}', [HomepageController::class, 'index']);
Route::get('/{slug}/{subSlug}', [HomepageController::class, 'index']);
