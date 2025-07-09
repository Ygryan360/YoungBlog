<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('contact', 'contact')->name('contact');
Route::view('about', 'about')->name('about');

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
});
