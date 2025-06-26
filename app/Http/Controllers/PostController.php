<?php

namespace App\Http\Controllers;

use App\Models\Post;
use Illuminate\Contracts\View\View;

class PostController extends Controller
{
    public function show(string $slug, Post $post): View
    {
        if ($post->status !== 'published') {
            abort(404);
        }
        return view('post', compact('post'));
    }
}
