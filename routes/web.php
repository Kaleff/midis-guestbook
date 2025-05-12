<?php

use App\Http\Controllers\AdminController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::post('post/store', [PostController::class, 'store'])->name('post.store');
Route::post('post/destroy', [PostController::class, 'destroy'])->name('post.destroy');

Route::get('dashboard', [PostController::class, 'indexAdmin'])
    ->middleware(['auth'])
    ->name('dashboard');

Route::get('admins', [AdminController::class, 'index'])
    ->middleware(['auth'])
    ->name('admins');

Route::post('admin/store', [AdminController::class, 'store'])
    ->middleware(['auth'])
    ->name('admin.store');

Route::post('admin/destroy', [AdminController::class, 'destroy'])
    ->middleware(['auth'])
    ->name('admin.destroy');

Route::post('post/destroyAsAdmin', [PostController::class, 'destroyAsAdmin'])
    ->middleware(['auth'])
    ->name('post.destroyAsAdmin');

Route::post('post/storeAsAdmin', [PostController::class, 'storeAsAdmin'])
    ->middleware(['auth'])
    ->name('post.storeAsAdmin');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
