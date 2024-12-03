<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Frontend\BlogController;
use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController;
use App\Http\Controllers\Admin\PageController;
use App\Http\Controllers\Frontend\HomepageController;
use App\Http\Controllers\Frontend\PageController as FrontendPageController;

Route::get('/', [HomepageController::class, 'index'])->name('home.index');
Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
Route::get('/blog/{slug}', [BlogController::class, 'detail'])->name('blog.detail');


Route::middleware(['auth', 'verified'])->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('admin')->group(function (){
        Route::get('dashboard', [DashboardController::class, 'index'])->name('dashboard.index');
        Route::resource('pages', PageController::class);

        Route::prefix('blog')->group(function () {
            // 
            Route::resource('posts', PostController::class);
            Route::resource('categories', CategoryController::class);
        });
    });
});

require __DIR__.'/auth.php';
