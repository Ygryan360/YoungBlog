<?php

use App\Http\Controllers\PostController;
use Illuminate\Support\Facades\Route;

Route::view('/', 'home')->name('home');
Route::view('contact', 'contact')->name('contact');
Route::view('about', 'about')->name('about');
Route::get('/posts/{slug}-{post}', [PostController::class, 'show'])
    ->name('posts.show')
    ->where('slug', '[a-z0-9\-]+')
    ->where('post', '[0-9]+');
