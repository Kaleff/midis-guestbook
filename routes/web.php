<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;
use Inertia\Inertia;

Route::get('/', [PostController::class, 'index'])->name('home');
Route::post('post/store', [PostController::class, 'store'])->name('post.store');
Route::post('post/destroy', [PostController::class, 'destroy'])->name('post.destroy');

Route::get('dashboard', [PostController::class, 'indexAdmin'])
    ->middleware(['auth'])
    ->name('dashboard');

require __DIR__.'/settings.php';
require __DIR__.'/auth.php';
