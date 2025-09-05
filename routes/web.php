<?php

use App\Http\Controllers\AuthController;
use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('contact', 'contact')->name('contact');
Route::view('about', 'about')->name('about');

Route::middleware('guest')->group(function () {
    Route::view('login', 'auth.login')->name('login');
    Route::view('register', 'auth.register')->name('register');
    Route::post('/login', [AuthController::class, 'login'])->name('login.post');
    Route::post('/register', [AuthController::class, 'register'])->name('register.post');
});

Route::get('/category/{slug}', [PostController::class, 'category'])
    ->where('slug', '[a-z0-9\-]+')
    ->name('posts.category');

Route::get('/tag/{name}', [PostController::class, 'tag'])
    ->where('name', '[a-z0-9\-]+')
    ->name('posts.tag');

Route::get('/articles/{slug}-{post}', [PostController::class, 'show'])
    ->where('slug', '[a-z0-9\-]+')
    ->where('post', '[0-9]+')
    ->name('posts.show');

Route::get('newsletter', [PostController::class, 'newsletter'])
    ->name('newsletter');

Route::middleware('auth')->group(function () {
    Route::get('/posts/preview/{post}', [PostController::class, 'preview'])
        ->where('slug', '[a-z0-9\-]+')
        ->name('posts.preview');

    Route::get('/verify-email', [AuthController::class, 'showConfirmEmailForm'])
        ->name('verification.show');

    Route::post('/verify-email', [AuthController::class, 'confirmEmail'])
        ->name('verification.confirm');

    Route::view('profile', 'auth.profile')->name('profile');

    Route::post('logout', [AuthController::class, 'logout'])->name('logout');

    Route::post('/articles/{post}/comments', [\App\Http\Controllers\CommentController::class, 'store'])
        ->name('comments.store');

    Route::delete('/comments/{comment}', [\App\Http\Controllers\CommentController::class, 'destroy'])
        ->name('comments.destroy');
});
