<?php

use App\Models\Blog;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    $categories = Category::withCount('blogs')->get();
    $blogs = Blog::with('categories')->get();
    return view('home', compact('categories', 'blogs'));
})->name('home');

Route::prefix('auth')->group(function () {
    Route::get('/login', [App\Http\Controllers\Auth\LoginController::class, 'index'])->name('auth.login');
    Route::post('/login', [App\Http\Controllers\Auth\LoginController::class, 'login'])->name('login');

    Route::get('/profile', [App\Http\Controllers\Auth\LoginController::class, 'profile'])->name('auth.profile');
    Route::post('/profile', [App\Http\Controllers\Auth\LoginController::class, 'update'])->name('profile.update');

    Route::get('/register', [App\Http\Controllers\Auth\RegisterController::class, 'index'])->name('auth.register');
    Route::post('/register', [App\Http\Controllers\Auth\RegisterController::class, 'register'])->name('register');

    Route::post('/logout', [App\Http\Controllers\Auth\LoginController::class, 'logout'])->name('logout');
});


Route::post('/check-username', [App\Http\Controllers\Auth\RegisterController::class, 'checkUsername']);
Route::post('/check-email', [App\Http\Controllers\Auth\RegisterController::class, 'checkEmail']);

Route::prefix('blog')->middleware('auth')->group(function () {
    Route::get('/create', [App\Http\Controllers\BlogController::class, 'create'])->name('blogs');
    Route::post('/create', [App\Http\Controllers\BlogController::class, 'store'])->name('store.blog');
    Route::get('/{userId}', [App\Http\Controllers\BlogController::class, 'myblog'])->name('myblog');

    Route::get('/blog/{slug}', [App\Http\Controllers\BlogController::class, 'show'])->name('blog.show');
});

Route::prefix('category')->middleware('auth')->group(function () {
    Route::get('/create', [App\Http\Controllers\CategoryController::class, 'create'])->name('category.create');
    Route::post('/category', [App\Http\Controllers\CategoryController::class, 'store'])->name('category.created');
});
