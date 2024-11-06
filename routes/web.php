<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Member\PostController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    return view('dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::prefix('blogs')->group(function() {
        Route::resource('category', CategoryController::class);
        Route::resource('post', PostController::class);
    
    });
});

require __DIR__.'/auth.php';
